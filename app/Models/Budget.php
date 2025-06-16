<?php

<<<<<<< HEAD
// app/Models/Budget.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['id','user_id', 'category_id', 'month', 'year', 'date', 'amount','created_At','updated_At'];
=======
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
        'amount'
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
>>>>>>> 7f4954b (Updated Chatbot)
}
