<?php

// app/Models/Budget.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['id','user_id', 'category_id', 'month', 'year', 'date', 'amount','created_At','updated_At'];
}
