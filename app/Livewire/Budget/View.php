<?php

namespace App\Livewire\Budget;

use Livewire\Component;
use App\Models\Budget;

class View extends Component
{
    public $budget;
    public $confirmingDelete = false;
    public $budgetIdToDelete = null;
    public $deleteId = null;

    public function mount($id): void
    {
        $this->budget = Budget::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.budget.view')->layout('layouts.app');
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
}
