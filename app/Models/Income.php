<?php

namespace App\Models;

use App\Observers\IncomeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([IncomeObserver::class])]
class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'currency', // currency field has been added...
        'user_id',
    ];
}
