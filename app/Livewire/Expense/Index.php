<?php

namespace App\Livewire\Expense;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    public $expenses;
    public $search = '';
    public $perPage = 10;

    public $selectedMonth;
    public $selectedYear;


    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->format('Y');
        $this->expenses = Expense::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.expense.index')->layout('layouts.app');
    }
}
