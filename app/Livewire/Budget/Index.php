<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $budgets;
    public $remainingBudget;
    public $salary;

    public function mount(): void
    {
        $user = Auth::user();
        $this->budgets = Budget::with('category')->where('user_id', auth()->id())->get();
        $this->remainingBudget = Budget::currentBudget();
        $this->salary = $user->salary;

    }

    public function render()
    {
        return view('livewire.budget.index')->layout('layouts.app');
    }
}
