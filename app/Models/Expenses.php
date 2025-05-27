<?php

// app/Models/Expense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = ['id','user_id', 'expense_category_id', 'amount', 'description', 'date', 'payment_method','created_At','updated_At','is_recurring'];

    public function category()
    {
        return $this->belongsTo(\App\Models\ExpenseCategory::class, 'expense_category_id');
    }
}
