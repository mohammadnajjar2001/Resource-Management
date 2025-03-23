<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondProduct extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'package_count', 'unit_count', 'price_usd', 'notes'];
}
