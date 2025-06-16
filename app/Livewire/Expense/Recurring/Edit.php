<?php

namespace App\Livewire\Expense\Recurring;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('livewire.expense.recurring.edit')->layout('layouts.app');;
    }
}
