<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\SecondProduct;
use Illuminate\Http\Request;

class SecondProductController extends Controller
{

    public function index(Request $request)
    {
        $request = request();
        $query = SecondProduct::query();
        // $SecondProducts = SecondProduct::all();
        $name = $request->get('name', '');

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        // ترتيب الملاحظات حسب الأحدث تعديلًا
        $products = $query->orderBy('updated_at', 'desc')->get();

        return view('SecondProducts.index', compact('products', 'name'));
    }
    public function create()
    {
        return view('SecondProducts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        SecondProduct::create($request->all());

        return redirect()->route('second-products.index')->with('add', 'تمت إضافة المنتج بنجاح!');
    }

    public function show(SecondProduct $second_product)
    {
        $product=$second_product;
        $currencyRate = CurrencyRate::latest()->first(); // جلب أحدث سعر صرف

        if (!$currencyRate) {
            return back()->with('error', 'لم يتم العثور على أسعار الصرف. الرجاء إضافتها أولاً.');
        }

        // تحويل السعر إلى الليرة التركية والسورية
        $priceInTry = $product->price * $currencyRate->usd_to_try;
        $priceInSyp = $product->price * $currencyRate->usd_to_syp;

        return view('SecondProducts.product-price', compact('product', 'priceInTry', 'priceInSyp'));

    }


    public function edit(SecondProduct $SecondProduct)
    {
        return view('SecondProducts.edit', compact('SecondProduct'));
    }

    public function update(Request $request, SecondProduct $SecondProduct)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $SecondProduct->update($request->all());

        return redirect()->route('second-products.index')->with('update', 'تم تحديث المنتج بنجاح!');
    }

    public function destroy(SecondProduct $SecondProduct)
    {
        $SecondProduct->delete();
        return redirect()->route('second-products.index')->with('delete', 'تم حذف المنتج بنجاح!');
    }
}
