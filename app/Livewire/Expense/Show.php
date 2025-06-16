<?php

namespace App\Livewire\Expense;

use App\Models\Expense;
use App\Models\RecurringExpense;
use Livewire\Component;

class Show extends Component
{
    public $expense;
    public $realExpense;
    public $isEdit = false;
    public $categories;

    public function mount($id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return redirect()->route('expense.index')->with('error', 'Expense not found.');
        }

        $this->expense = $expense->toArray();
        $this->expense['is_recurring'] = $expense->is_recurring ? true : false;
        $this->realExpense = $expense;
        $this->categories = \App\Models\ExpenseCategory::all();
    }

    public function render()
    {
        return view('livewire.expense.show')->layout('layouts.app');;
    }

    public function resetForm()
    {
        $this->expense = $this->realExpense->toArray();
        $this->expense['is_recurring'] = $this->realExpense->is_recurring ? true : false;
        $this->isEdit = false;
    }

    public function update()
    {
        $this->validate([
            'expense.amount' => 'required|numeric|min:0',
            'expense.description' => 'required|string|max:255',
            'expense.date' => 'required|date',
        ], [
            'expense.description.required' => 'The description is required.',
            'expense.description.string' => 'The description must be a string.',
            'expense.description.max' => 'The description may not be greater than 255 characters.',
            'expense.amount.required' => 'The amount is required.',
            'expense.amount.numeric' => 'The amount must be a number.',
            'expense.amount.min' => 'The amount must be at least 0.',
            'expense.description.string' => 'The description must be a string.',
            'expense.description.max' => 'The description may not be greater than 255 characters.',
            'expense.date.required' => 'The date is required.',
            'expense.date.date' => 'The date is not a valid date.',
        ]);

        $this->realExpense->update([
            'amount' => $this->expense['amount'],
            'description' => $this->expense['description'],
            'date' => $this->expense['date'],
            'is_recurring' => $this->expense['is_recurring'] ? 1 : 0,
        ]);

        if ($this->expense['is_recurring']) {
            RecurringExpense::updateOrCreate([
                'user_id' => $this->realExpense->user_id,
                'description' => $this->expense['description'],
                'amount' => $this->expense['amount'],
            ],[
                'start_date' => $this->expense['date'],
                'end_date' => date('Y-m-d', strtotime($this->expense['date'] . ' +1 year')),
                'next_payment_date' => date('Y-m-d', strtotime($this->expense['date'] . ' +1 month')),
                'last_payment_date' => date('Y-m-d', strtotime($this->expense['date'] . ' +1 year')),
                'frequency' => 'monthly',
                'is_active' => true,
            ]);
        }

        session()->flash('message', 'Expense updated successfully.');
        return redirect()->route('expense.index');
    }

    public function deleteExpense()
    {
        $this->realExpense->delete();
        session()->flash('message', 'Expense deleted successfully.');
        return redirect()->route('expense.index');
    }
}
