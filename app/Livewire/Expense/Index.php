<?php

namespace App\Livewire\Expense;

use App\Models\Budget;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    public $expenses;
    public $search = '';
    public $perPage = 10;

    public $selectedMonth;
    public $selectedYear;
    public $remainingBudgets = [];


    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->format('Y');
        $this->expenses = Expense::where('user_id', Auth::id())->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $budgets = Budget::where('user_id', auth()->id())
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();
        $expenses = Expense::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->where('user_id', auth()->id())
            ->get();
        $expenseSums = $expenses->groupBy('expense_category_id')->map(function ($group) {
            return $group->sum('amount');
        });
        foreach ($budgets as $budget) {
            if ($budget->category_id != 0) {
                $spent = $expenseSums[$budget->category_id] ?? 0;
                $this->remainingBudgets[] = [
                    'category' => $budget->category->name,
                    'color_code' => $budget->category->color_code,
                    'budget' => $budget->amount,
                    'spent' => $spent,
                    'remaining' => $budget->amount - $spent,
                ];
            } else {
                $totalSpent = 0;
                foreach ($expenses as $expense) {
                    $totalSpent += $expense->amount;
                }
                $this->remainingBudgets[] = [
                    'category' => 'All',
                    'color_code' => '#ffffff',
                    'budget' => $budget->amount,
                    'spent' => $totalSpent,
                    'remaining' => $budget->amount - $totalSpent,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.expense.index')->layout('layouts.app');
    }
}
