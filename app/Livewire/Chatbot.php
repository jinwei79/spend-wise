<?php

namespace App\Livewire;

use App\Models\Expenses;
use App\Models\RecurringExpenses;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Chatbot extends Component
{
    public $input = '';
    public $messages = [];
    public $isTyping = false;
    public bool $isOpen = false;

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function mount()
    {
        $this->messages = session()->get('chat_messages', []);
    }

    public function sendMessage()
    {
        if (empty($this->input)) return;

        $userMessage = strtolower(trim($this->input));

        $this->messages[] = [
            'role' => 'user',
            'content' => $this->input
        ];

        // Check for "contact us" questions
        if (
            str_contains($userMessage, 'contact') ||
            str_contains($userMessage, 'support') ||
            str_contains($userMessage, 'reach you') ||
            str_contains($userMessage, 'email') ||
            str_contains($userMessage, 'phone')
        ) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => "You can contact us via email at <strong>support@example.com</strong> or call us at <strong>+123-456-7890</strong>. We're available Monday to Friday, 9am–5pm."
            ];

            session()->put('chat_messages', $this->messages);
            $this->input = '';
            return;
        }

        // Otherwise → AI handles it
        $userId = auth()->id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $currentMonthName = Carbon::now()->format('F Y');

        $monthlyExpenses = Expenses::where('user_id', $userId)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->select('date', 'description', 'amount', 'expense_category_id')
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();

        $budgets = Budget::where('user_id', $userId)->get()->toArray();
        $recurring = RecurringExpenses::where('user_id', $userId)->get()->toArray();

        $expenseSummaryByCategory = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->where('expenses.user_id', $userId)
            ->whereMonth('expenses.date', $currentMonth)
            ->whereYear('expenses.date', $currentYear)
            ->select('expense_categories.name as category', DB::raw('SUM(expenses.amount) as total'))
            ->groupBy('expense_categories.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        // Detect intent
        $intent = '';
        if (
            str_contains($userMessage, 'summary') ||
            str_contains($userMessage, 'report')
        ) {
            $intent = 'summary';
        } elseif (
            str_contains($userMessage, 'list') &&
            str_contains($userMessage, 'expenses')
        ) {
            $intent = 'list';
        }

        // Build the system prompt
        $systemPrompt = "You are a helpful expense tracking assistant. Based on the data below, answer the user's question clearly and helpfully.\n";
        $systemPrompt .= "Use simple HTML formatting such as <strong>, <ul>, <li>, and <p> to keep responses clean.\n";
        $systemPrompt .= "Only use data from the current month ({$currentMonthName}).\n";
        $systemPrompt .= "Do not mention technical fields like IDs or raw JSON.\n";

        if ($intent === 'summary') {
            $systemPrompt .= "The user is asking for an expense summary. Include total spent, top categories, and optionally a breakdown by week.\n";
            $systemPrompt .= "If budget is available, show the remaining budget (budget minus expenses).\n";
        } elseif ($intent === 'list') {
            $systemPrompt .= "The user just wants a list of expenses. Show only the list of expenses for the current month in clear bullet format. Do not include budget info, recurring expenses, or summaries unless explicitly asked.\n";
        } else {
            $systemPrompt .= "Respond naturally. Use the data to answer appropriately. If unsure, give a short, clear overview.\n";
        }

        $systemPrompt .= "User's full expenses in the last 30 days: " . json_encode($monthlyExpenses) . "\n";
        $systemPrompt .= "User's budget data: " . json_encode($budgets) . "\n";
        $systemPrompt .= "User's recurring expenses: " . json_encode($recurring) . "\n";
        $systemPrompt .= "Expense summary by category: " . json_encode($expenseSummaryByCategory) . "\n";
        $systemPrompt .= "User's question: " . $this->input;

        $this->messages[] = [
            'role' => 'system',
            'content' => $systemPrompt
        ];

        $response = $this->callGroqApi($this->messages);

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response
            ];
        }

        session()->put('chat_messages', $this->messages);
        $this->input = '';
    }


    private function callGroqApi($messages)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                'messages' => $messages,
                'temperature' => 0.7
            ]);

            return $response->json()['choices'][0]['message']['content'] ?? null;

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Groq API error: ' . $e->getMessage());

            // Return a user-friendly error message
            return "Sorry, I couldn't process your request at the moment. Please try again later.";
        }
    }

    public function clearChat()
    {
        $this->messages = [];
        session()->forget('chat_messages');
    }

    public function render()
    {
        return view('livewire.chatbot')->layout('layouts.app');
    }
}
