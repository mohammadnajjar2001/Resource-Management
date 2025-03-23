<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\SecondProduct;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $currencyRate = CurrencyRate::latest()->first(); // جلب أحدث سعر صرف
        $products = SecondProduct::all();
        return view('MySite.dashboard', compact('currencyRate' , 'products'));
    }
}
