<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'month',
        'year',
        'amount',
        'spent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::class, 'category_id');
    }

    public static function currentBudget()
    {
        $currentBudget = $currentExpense = 0;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $currentMonthBudgets = Budget::with('category')
            ->where('user_id', Auth::id())
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        foreach ($currentMonthBudgets as $currentMonthBudget) {
            $currentBudget += $currentMonthBudget->amount;
        }

        $currentMonthExpenses = Expense::where('user_id', Auth::id())->get();
        foreach ($currentMonthExpenses as $currentMonthExpense) {
            $currentExpense += $currentMonthExpense->amount;
        }

        return $currentBudget - $currentExpense;
    }
}
