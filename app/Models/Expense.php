<?php

namespace App\Models;

use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'currency',
        'user_id',
    ];
}
