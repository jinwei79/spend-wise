<?php

namespace App\Livewire\Expense\Category;

use Livewire\Component;
use App\Models\ExpenseCategory;

class View extends Component
{
    public $category;
    public $confirmingDelete = false;
    public $categoryIdToDelete = null;
    public $deleteId = null;

    public function mount($id): void
    {
        $this->category = ExpenseCategory::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.expense.category.view')->layout('layouts.app');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function deleteCategory()
    {
        $deleteCategory = ExpenseCategory::findOrFail($this->deleteId);
        ExpenseCategory::findOrFail($this->deleteId)->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        $this->categories = ExpenseCategory::where('user_id', auth()->id())
            ->orWhere('is_default', true)
            ->get();

        session()->flash('success', 'Category (' . $deleteCategory->name . ') deleted successfully.');
        return redirect()->route('category.index');
    }
}
