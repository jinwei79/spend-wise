<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringExpenses extends Model
{
    protected $fillable = ['id','user_id', 'expense_category_id', 'amount', 'description', 'start_date', 'end_date', 'frequency', 'payment_method', 'is_active',
     'next_payment_date', 'last_payment_date','created_At','updated_At','is_recurring'];
}

