<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    public function chatWithGroq($content)
    {
        try {
            $response = Http::withToken(config('services.groq.key'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                    'messages' => [
                        ['role' => 'user', 'content' => $content]
                    ],
                ]);

            // Log full response
            Log::info('Groq API Response:', $response->json());

            $data = $response->json();

            if (!isset($data['choices'][0]['message']['content'])) {
                Log::warning('Groq API returned unexpected format:', $data);
                return 'No response from model.';
            }

            return $data['choices'][0]['message']['content'];

        } catch (\Exception $e) {
            Log::error('Groq API call failed: ' . $e->getMessage());
            return 'Error communicating with Groq API.';
        }
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
        $categoryId = isset($matches[0]) ? (int)strrev($matches[0]) : 0; // Reverse it back to get the original number
        return $categoryId;
    }
}
