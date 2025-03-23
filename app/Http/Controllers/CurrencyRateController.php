<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;

class CurrencyRateController extends Controller
{
    public function index()
    {
        $currencyRate = CurrencyRate::latest()->first(); // جلب أحدث سعر صرف
        return view('currency_rates.index', compact('currencyRate'));
    }

    public function create()
    {
        return view('currency_rates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usd_to_try' => 'required|numeric|min:0',
            'usd_to_syp' => 'required|numeric|min:0',
        ]);

        CurrencyRate::create($request->all());

        return redirect()->route('currency_rates.index')->with('add', 'تمت إضافة سعر الصرف بنجاح!');
    }

    public function edit()
    {
        $currencyRate = CurrencyRate::latest()->first();
        return view('currency_rates.edit', compact('currencyRate'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'usd_to_try' => 'required|numeric|min:0',
            'usd_to_syp' => 'required|numeric|min:0',
        ]);

        $currencyRate = CurrencyRate::latest()->first();
        $currencyRate->update($request->all());

        return redirect()->route('currency_rates.index')->with('update', 'تم تحديث سعر الصرف بنجاح!');
    }
}
