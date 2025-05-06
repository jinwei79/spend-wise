<?php

namespace App\Livewire\Expense\Category;

use Livewire\Component;
use App\Models\ExpenseCategory;

class Index extends Component
{
    public $categories;

    public function mount(): void
    {
        $this->categories = ExpenseCategory::where('user_id', auth()->id())
            ->orWhere('is_default', true)
            ->get();
    }

    public function render()
    {
        return view('livewire.expense.category.index')->layout('layouts.app');
    }
}
