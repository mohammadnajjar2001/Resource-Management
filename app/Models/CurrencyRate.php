<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'usd_to_try',
        'usd_to_syp',
    ];
}
