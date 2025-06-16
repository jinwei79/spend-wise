<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $table = 'budgets'; // adjust if needed

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'category_id');
    }
}
