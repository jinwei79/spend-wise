<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BudgetAlert extends Component
{
    public $showBudgetAlert = false;
    public $exceedCategories = [];

    public function mount()
    {
        $user = Auth::user();
        if (!$user) return;

        $budgets = Budget::where('user_id', auth()->id())->where('month',now()->month)->get();
        foreach ($budgets as $budget) {
            if ($budget->category_id != 0) {
                $spent = Expense::where('expense_category_id', $budget->category_id)
                    ->whereMonth('created_at', $budget->month)
                    ->whereYear('created_at', $budget->year)
                    ->sum('amount');

                if ($spent >= $budget->amount * 0.9) { // 90% threshold
                    $this->exceedCategories[] = $budget->category->name;
                }
            }
        }

        // TO CATER BUDGET FOR ALL CATEGORY
        foreach ($budgets as $budget) {
            if ($budget->category_id == 0) {
                $totalSpent = Expense::whereMonth('created_at', $budget->month)
                    ->whereYear('created_at', $budget->year)
                    ->sum('amount');

                if ($totalSpent >= $budget->amount * 0.9) { // 90% threshold
                    $this->exceedCategories[] = 'all other Categories';
                }
            }
        }

        if (!empty($this->exceedCategories)) {
            $dismissedAt = $user->budget_notice_dismissed_at;

            if (!$dismissedAt || $dismissedAt->month !== now()->month || $dismissedAt->year !== now()->year) {
                $this->showBudgetAlert = true;
            }
        }
    }

    public function dismissBudgetAlert()
    {
        $user = Auth::user();
        $user->budget_notice_dismissed_at = now();
        $user->save();

        $this->showBudgetAlert = false;
    }

    public function render()
    {
        return view('livewire.budget.budget-alert')->layout('layouts.app');
    }
}
