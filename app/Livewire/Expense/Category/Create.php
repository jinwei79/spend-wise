<?php

namespace App\Livewire\Expense\Category;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.expense.category.form')->layout('layouts.app');
    }
}
