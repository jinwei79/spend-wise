<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use Livewire\Component;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $budgetId;
    public $category_id;
    public $month;
    public $year;
    public $amount;
    public $categories;
    public $confirmingDelete = false;
    public $deleteId = null;

    public function mount($id = null)
    {
        if ($id) {
            $budget = Budget::findOrFail($id);
            $this->budgetId = $budget->id;
            $this->category_id = $budget->category_id;
            $this->month = $budget->month;
            $this->year = $budget->year;
            $this->amount = $budget->amount;
        }
        $this->categories = ExpenseCategory::where('user_id', auth()->id())
            ->orWhere('is_default', true)
            ->get();
    }

    public function save()
    {
        $this->validate([
            'category_id' => 'required',
            'month' => 'required|int',
            'year' => 'required|int',
            'amount' => 'required|numeric|min:0',
        ]);

        $existingBudget = Budget::where('category_id', $this->category_id)
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingBudget && $existingBudget->id !== $this->budgetId) {
            session()->flash('error', 'A budget for this category and month already exists. Please edit that budget instead.');
            return redirect()->route('budget.index');
        }

        Budget::updateOrCreate(
            ['id' => $this->budgetId],
            [
                'category_id' => $this->category_id,
                'month' => $this->month,
                'year' => $this->year,
                'amount' => $this->amount,
                'user_id' => Auth::id(),
            ]
        );

        session()->flash('success', $this->budgetId ? 'Budget updated successfully.' : 'Budget created successfully.');
        return redirect()->route('budget.index');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function deleteBudget()
    {
        Budget::findOrFail($this->deleteId)->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Budget deleted successfully.');
        return redirect()->route('budget.index');
    }

    public function render()
    {
        return view('livewire.budget.form')->layout('layouts.app');
    }
}
