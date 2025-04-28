<?php

namespace App\Livewire\Expense\Recurring;

use App\Models\RecurringExpense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $recurringExpenses;


    public function mount()
    {
        $this->recurringExpenses = RecurringExpense::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.expense.recurring.index')->layout('layouts.app');
    }

    public function showExpense($expenseId)
    {
        return redirect()->route('recurring-expense.show', [$expenseId]);
    }
}
