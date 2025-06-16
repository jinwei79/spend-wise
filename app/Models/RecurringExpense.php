<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    protected $fillable = [
        'user_id',
        'expense_category_id',
        'amount',
        'description',
        'start_date',
        'end_date',
        'frequency',
        'payment_method',
        'is_active',
        'next_payment_date',
        'last_payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
