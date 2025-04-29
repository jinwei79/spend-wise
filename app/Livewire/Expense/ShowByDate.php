<?php

namespace App\Livewire\Expense;

use Livewire\Component;

class ShowByDate extends Component
{
    public $expenses;
    public $date;

    public function mount($date)
    {
        $this->date = $date;
        $this->expenses = \App\Models\Expense::where('user_id', auth()->id())
            ->whereDate('date', $date)
            ->get();
    }

    public function render()
    {
        return view('livewire.expense.show-by-date')->layout('layouts.app');;
    }

    public function showExpense($expenseId)
    {
        return redirect()->route('expense.show', [$expenseId]);
    }
}
