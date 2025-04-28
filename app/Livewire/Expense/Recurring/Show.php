<?php

namespace App\Livewire\Expense\Recurring;

use App\Models\Expense;
use App\Models\RecurringExpense;
use Livewire\Component;

class Show extends Component
{
    public $expense;
    public $realExpense;
    public $isEdit = false;

    public function mount($id)
    {
        $expense = RecurringExpense::find($id);
        if (!$expense) {
            return redirect()->route('recurring-expense.index')->with('error', 'Recurring expense not found.');
        }

        $this->expense = $expense->toArray();
        $this->realExpense = $expense;
    }

    public function render()
    {
        return view('livewire.expense.recurring.show')->layout('layouts.app');
    }

    public function resetForm()
    {
        $this->expense = $this->realExpense->toArray();
        $this->isEdit = false;
    }

    public function update()
    {
        $this->validate([
            'expense.amount' => 'required|numeric|min:0',
            'expense.description' => 'required|string|max:255',
            'expense.start_date' => 'required|date',
            'expense.end_date' => 'nullable|date|after_or_equal:expense.start_date',
            'expense.frequency' => 'required|in:daily,weekly,monthly,yearly',
            'expense.is_active' => 'boolean',
        ], [
            'expense.description.required' => 'The description is required.',
            'expense.description.string' => 'The description must be a string.',
            'expense.description.max' => 'The description may not be greater than 255 characters.',
            'expense.amount.required' => 'The amount is required.',
            'expense.amount.numeric' => 'The amount must be a number.',
            'expense.amount.min' => 'The amount must be at least 0.',
            'expense.description.string' => 'The description must be a string.',
            'expense.description.max' => 'The description may not be greater than 255 characters.',
            'expense.start_date.required' => 'The start date is required.',
            'expense.start_date.date' => 'The start date is not a valid date.',
            'expense.end_date.date' => 'The end date is not a valid date.',
            'expense.end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'expense.frequency.required' => 'The frequency is required.',
            'expense.frequency.in' => 'The frequency must be one of the following: daily, weekly, monthly, yearly.',
            'expense.is_active.boolean' => 'The active status must be true or false.',
        ]);

        $this->realExpense->update([
            'amount' => $this->expense['amount'],
            'description' => $this->expense['description'],
            'start_date' => $this->expense['start_date'],
            'end_date' => $this->expense['end_date'],
            'frequency' => $this->expense['frequency'],
            'is_active' => $this->expense['is_active'] ? 1 : 0,
            'next_payment_date' => $this->getNextPaymentDate($this->expense['frequency'], $this->expense['start_date']),
            'last_payment_date' => $this->expense['end_date'],
        ]);

        session()->flash('message', 'Recurring expense updated successfully.');
        return redirect()->route('recurring-expense.index');
    }

    public function deleteExpense()
    {
        $this->realExpense->delete();
        session()->flash('message', 'Recurring expense deleted successfully.');
        return redirect()->route('recurring-expense.index');
    }

    public function getNextPaymentDate($frequency, $startDate)
    {
        switch ($frequency) {
            case 'daily':
                return date('Y-m-d', strtotime($startDate . ' +1 day'));
            case 'weekly':
                return date('Y-m-d', strtotime($startDate . ' +1 week'));
            case 'monthly':
                return date('Y-m-d', strtotime($startDate . ' +1 month'));
            case 'yearly':
                return date('Y-m-d', strtotime($startDate . ' +1 year'));
            default:
                return $startDate;
        }
    }
}
