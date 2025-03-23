<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\SecondProduct;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SecondProductsImport;

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
            'name'          => 'required|string|max:255',
            'package_count' => 'integer|min:0', // 0 أن يكون عدد العبوات أكبر من أو يساوي
            'unit_count'    => 'required|numeric|min:1',  // يجب أن يكون عدد الوحدات أكبر من أو يساوي 1
            'price_usd'     => 'required|numeric|min:0.01', // يجب أن يكون السعر أكبر من 0
            'notes'         => 'nullable|string|max:1000',  // ملاحظة اختيارية ولكن إذا كانت موجودة يجب أن تكون سلسلة نصية
        ]);

        SecondProduct::create($request->all());

        return redirect()->route('second-products.index')->with('add', 'تمت إضافة المنتج بنجاح!');
    }

    public function show(SecondProduct $second_product)
    {
        $product = $second_product;
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
            'name'          => 'required|string|max:255',
            'package_count' => 'integer|min:0', // 0 أن يكون عدد العبوات أكبر من أو يساوي
            'unit_count'    => 'required|numeric|min:1',  // يجب أن يكون عدد الوحدات أكبر من أو يساوي 1
            'price_usd'     => 'required|numeric|min:0.01', // يجب أن يكون السعر أكبر من 0
            'notes'         => 'nullable|string|max:1000',  // ملاحظة اختيارية ولكن إذا كانت موجودة يجب أن تكون سلسلة نصية
        ]);

        $SecondProduct->update($request->all());

        return redirect()->route('second-products.index')->with('update', 'تم تحديث المنتج بنجاح!');
    }

    public function destroy(SecondProduct $SecondProduct)
    {
        $SecondProduct->delete();
        return redirect()->route('second-products.index')->with('delete', 'تم حذف المنتج بنجاح!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new SecondProductsImport, $request->file('excel_file'));

        return redirect()->route('second-products.index')->with('add', 'تم استيراد البيانات بنجاح!');
    }
    public function reduceUnit($id)
    {
        $product = SecondProduct::findOrFail($id);

        if ($product->unit_count > 0) {
            $product->unit_count -= 1;
            $product->save();

            return redirect()->back()->with('update', 'تم إنقاص قطعة من المنتج.');
        }

        return redirect()->back()->with('error', 'لا يوجد وحدات متاحة.');
    }
    public function reduceUnit2($id)
    {
        $product = SecondProduct::findOrFail($id);


            $product->unit_count += 1;
            $product->save();

            return redirect()->back()->with('add', 'تم زيادة قطعة من المنتج.');
    }

}
