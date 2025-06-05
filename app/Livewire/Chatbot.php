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

        dd($this->messages);
        if (empty($this->input)) return;

        $userMessage = strtolower($this->input);

        $this->messages[] = [
            'role' => 'user',
            'content' => $this->input
        ];

        // Fetch recent expenses
        $expenses = Expenses::where('date', '>=', Carbon::now()->subDays(30))
            ->where('user_id', auth()->id())
            ->get(['description', 'amount', 'date'])
            ->toArray();

        // Fetch budget
        $budgets = Budget::where('user_id', auth()->id())
            ->get(['amount', 'created_at'])
            ->toArray();

        // Fetch recurring expenses
        $recurring = RecurringExpenses::where('user_id', auth()->id())->get(['description', 'amount', 'frequency', 'next_payment_date'])
            ->toArray();

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
                'content' => "You can contact us via email at **support@example.com** or call us at **+123-456-7890**. We're available Monday to Friday, 9am–5pm."
            ];

            session()->put('chat_messages', $this->messages);
            $this->input = '';
            return;
        }

        // Fetch category expenses
        $expenseSummaryByCategory = DB::table('expenses')
        ->where('expenses.user_id', auth()->id())
        ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
        ->where('expenses.date', '>=', Carbon::now()->subDays(30))
        ->select('expense_categories.name as category', DB::raw('SUM(expenses.amount) as total'))
        ->groupBy('expense_categories.name')
        ->orderByDesc('total')
        ->get()
        ->toArray();

        // Generate weekly report
        $weeklySpending = DB::table('expenses')
        ->where('user_id', auth()->id())
        ->select(
            DB::raw('YEARWEEK(date, 1) as week'),
            DB::raw('MIN(date) as start_date'),
            DB::raw('MAX(date) as end_date'),
            DB::raw('SUM(amount) as total_spent')
        )
        ->where('date', '>=', Carbon::now()->subWeeks(4)) // past 4 weeks
        ->groupBy(DB::raw('YEARWEEK(date, 1)'))
        ->orderBy(DB::raw('YEARWEEK(date, 1)'), 'desc')
        ->get()
        ->toArray();

        // Generate monthly report
        $monthlySpending = DB::table('expenses')
        ->where('user_id', auth()->id())
        ->select(
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
            DB::raw('MIN(date) as start_date'),
            DB::raw('MAX(date) as end_date'),
            DB::raw('SUM(amount) as total_spent')
        )
        ->where('date', '>=', Carbon::now()->subMonths(6)) // past 6 months
        ->groupBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'))
        ->orderBy(DB::raw('DATE_FORMAT(date, "%Y-%m")'), 'desc')
        ->get()
        ->toArray();

        $systemPrompt = "Here is the user's expense data: " . json_encode($expenses) .
            ". Here is the user's budget data: " . json_encode($budgets) .
            ". Here is the user's recurring expenses: " . json_encode($recurring) .
            ". Here is the summary of expenses by category: " . json_encode($expenseSummaryByCategory) .
            ". Here is the weekly spending report: " . json_encode($weeklySpending) .
            ". Here is the user's monthly spending report: " . json_encode($monthlySpending) .
            ". Based on this data, answer the following question: " . $this->input;

        $this->messages[] = [
            'role' => 'system',
            'content' => "Expense data: " . json_encode($expenses) .
                " | Budget data: " . json_encode($budgets) .
                " | Recurring expense data: " . json_encode($recurring) .
                " | Category summary: " . json_encode($expenseSummaryByCategory) .
                " | Weekly spending report: " . json_encode($weeklySpending) .
                " | Monthly spending report: " . json_encode($monthlySpending)
        ];

        // Call Groq API
        $response = $this->callGroqApi($this->messages);

        // Add assistant's reply
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
                'model' => 'llama-3.1-8b-instant',
                'messages' => $messages,
                'temperature' => 0.7
            ]);

            return $response->json()['choices'][0]['message']['content'] ?? null;

        } catch (\Exception $e) {
            return "Sorry, I couldn't reach the AI.";
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
