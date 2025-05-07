<?php

namespace App\Livewire\Expense;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\RecurringExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{

    public $categories;
    public $remainingBudgets;

    public $expenses = [
        [
            'amount' => null,
            'description' => null,
            'date' => null,
            'is_recurring' => false,
            'expense_category_id' => null,
        ]
    ];

    public function mount()
    {
        $this->categories = \App\Models\ExpenseCategory::all();
        $this->expenses[0]['date'] = date('Y-m-d');

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $budgets = Budget::where('user_id', auth()->id())
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();
        $expenses = Expense::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->where('user_id', auth()->id())
            ->get();
        $expenseSums = $expenses->groupBy('expense_category_id')->map(function ($group) {
            return $group->sum('amount');
        });
        foreach ($budgets as $budget) {
            if ($budget->category_id != 0) {
                $spent = $expenseSums[$budget->category_id] ?? 0;
                $this->remainingBudgets[] = [
                    'category' => $budget->category->name,
                    'color_code' => $budget->category->color_code,
                    'budget' => $budget->amount,
                    'spent' => $spent,
                    'remaining' => $budget->amount - $spent,
                ];
            } else {
                $totalSpent = 0;
                foreach ($expenses as $expense) {
                    $totalSpent += $expense->amount;
                }
                $this->remainingBudgets[] = [
                    'category' => 'All',
                    'color_code' => '#ffffff',
                    'budget' => $budget->amount,
                    'spent' => $totalSpent,
                    'remaining' => $budget->amount - $totalSpent,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.expense.create')->layout('layouts.app');
    }

    public function save()
    {
        foreach ($this->expenses as $expense) {
            $this->validate([
                'expenses.*.amount' => 'required|numeric|min:0',
                'expenses.*.description' => 'required|string|max:255',
                'expenses.*.date' => 'required|date',
            ], [
                'expenses.*.description.required' => 'The description is required.',
                'expenses.*.description.string' => 'The description must be a string.',
                'expenses.*.description.max' => 'The description may not be greater than 255 characters.',
                'expenses.*.amount.required' => 'The amount is required.',
                'expenses.*.amount.numeric' => 'The amount must be a number.',
                'expenses.*.amount.min' => 'The amount must be at least 0.',
                'expenses.*.description.string' => 'The description must be a string.',
                'expenses.*.description.max' => 'The description may not be greater than 255 characters.',
                'expenses.*.date.required' => 'The date is required.',
                'expenses.*.date.date' => 'The date is not a valid date.',
            ]);

        }


        foreach ($this->expenses as $expense) {
            $expense['user_id'] = Auth::id();
            $expense['expense_category_id'] = $expense['expense_category_id'] ?? null;
            Expense::create($expense);

            if ($expense['is_recurring']) {
                $recurringExpense = $expense;
                $recurringExpense['description'] = $expense['description'];
                $recurringExpense['amount'] = $expense['amount'];
                $recurringExpense['frequency'] = 'monthly';
                $recurringExpense['is_active'] = false;
                $recurringExpense['start_date'] = $expense['date'];
                $recurringExpense['end_date'] = date('Y-m-d', strtotime($expense['date'] . ' +1 year'));
                $recurringExpense['next_payment_date'] = date('Y-m-d', strtotime($expense['date'] . ' +1 month'));
                $recurringExpense['last_payment_date'] = date('Y-m-d', strtotime($expense['date'] . ' +1 year'));
                $recurringExpense['user_id'] = Auth::id();
                RecurringExpense::create($recurringExpense);
            }
        }
        session()->flash('message', 'Expense created successfully.');
        return redirect()->route('expense.index');
    }

    public function addExpenseRow()
    {
        $this->expenses[] = [
            'amount' => null,
            'description' => null,
            'date' => date('Y-m-d'),
            'is_recurring' => false,
            'expense_category_id' => null,
        ];
    }

    public function removeExpenseRow($index)
    {
        unset($this->expenses[$index]);
        $this->expenses = array_values($this->expenses);
    }

    public function onChangeDescription($index)
    {
        $this->expenses[$index]['expense_category_id'] = $this->categories->random()->id;
    }
}
