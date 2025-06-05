<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GroqService
{
    public function chatWithGroq($content)
    {
        $response = Http::withToken(env('GROQ_API_KEY'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'user', 'content' => $content]
                ],
            ]);

        return $response->json()['choices'][0]['message']['content'];
    }

    public function getExpenseCategory($description)
    {
        $categories = ExpenseCategory::where('is_default', 1)->orWhere('user_id', Auth::id())->pluck('name', 'id')->toArray();
        $response = $this->chatWithGroq(
            "Categories:\n" .
            collect($categories)->map(fn($name, $id) => "$id: $name")->implode("\n") .
            "\nExpense: \"$description\"\nReply with the best category id, or 0 if none."
        );
        $reversedResponse = strrev($response); // Reverse the string
        preg_match('/\d+/', $reversedResponse, $matches); // Extract the first number
        $categoryId = isset($matches[0]) ? (int) strrev($matches[0]) : 0; // Reverse it back to get the original number
        return $categoryId;
    }
}
