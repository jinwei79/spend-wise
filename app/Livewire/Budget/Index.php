<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $budgets;
    public $remainingBudget;
    public $currentBudgets;
    public $otherBudgets;
    public $salary;

    public function mount(): void
    {
        $user = Auth::user();
        $this->budgets = Budget::with('category')->where('user_id', auth()->id())->orderByDesc('year')->orderByDesc('month')->get();
        $this->remainingBudget = Budget::currentBudget();
        $this->salary = $user->salary;

        [$this->currentBudgets, $this->otherBudgets] = $this->budgets->partition(function ($b) {
            return $b->month == now()->month && $b->year == now()->year;
        });

        foreach ($this->currentBudgets as $budget) {
            if ($budget->category_id == 0) {
                // Budget for all categories
                $spent = Expense::where('user_id', auth()->id())
                    ->whereMonth('date', $budget->month)
                    ->whereYear('date', $budget->year)
                    ->sum('amount');

                $budget->spent = $spent;

            } else {
                // Budget for a specific category
                $spent = Expense::where('user_id', auth()->id())
                    ->where('expense_category_id', $budget->category_id)
                    ->whereMonth('date', $budget->month)
                    ->whereYear('date', $budget->year)
                    ->sum('amount');

                $budget->spent = $spent;
            }
        }
    }

    public function render()
    {
        return view('livewire.budget.index')->layout('layouts.app');
    }
}
