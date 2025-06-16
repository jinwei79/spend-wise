<?php

namespace App\Livewire\Expense\Category;

use Livewire\Component;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $categoryId;
    public $name;
    public $description;
    public $color_code = '#000000';

    public function mount($id = null)
    {
        if ($id) {
            $category = ExpenseCategory::findOrFail($id);
            $this->categoryId = $category->id;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->color_code = $category->color_code;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color_code' => 'required|string',
        ]);

        ExpenseCategory::updateOrCreate(
            ['id' => $this->categoryId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'color_code' => $this->color_code,
                'user_id' => Auth::id(),
            ]
        );

        session()->flash('success', $this->categoryId ? 'Category updated successfully.' : 'Category created successfully.');
        return redirect()->route('category.index');
    }

    public function render()
    {
        return view('livewire.expense.category.form')->layout('layouts.app');
    }
}
