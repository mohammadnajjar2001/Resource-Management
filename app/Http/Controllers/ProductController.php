<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request = request();
        $query=Product::query();
        // $products = Product::all();
        $name = $request->get('name', '');
        $barcode = $request->get('barcode', '');

        if($name){
            $query->where('name','LIKE',"%{$name}%");
        }
        if($barcode){
            $query->where('barcode','LIKE',"%{$barcode}%");
        }

        // ترتيب الملاحظات حسب الأحدث تعديلًا
        $products = $query->orderBy('updated_at', 'desc')->get();

        return view('products.index', compact('products','barcode','name'));
        // return view('notes.index', compact('notes', 'title', 'content', 'is_favorite', 'categories', 'category_id'));
    }
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'barcode' => 'required|string|unique:products|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('add', 'تمت إضافة المنتج بنجاح!');
    }

    public function show(Product $product)
    {
        $currencyRate = CurrencyRate::latest()->first(); // جلب أحدث سعر صرف

        if (!$currencyRate) {
            return back()->with('error', 'لم يتم العثور على أسعار الصرف. الرجاء إضافتها أولاً.');
        }

        // تحويل السعر إلى الليرة التركية والسورية
        $priceInTry = $product->price * $currencyRate->usd_to_try;
        $priceInSyp = $product->price * $currencyRate->usd_to_syp;

        return view('products.product-price', compact('product', 'priceInTry', 'priceInSyp'));
    }


    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'barcode' => "required|string|max:255|unique:products,barcode,{$product->id}",
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('update', 'تم تحديث المنتج بنجاح!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('delete', 'تم حذف المنتج بنجاح!');
    }
    public function scanBarcode()
    {
        return view('products.scan-barcode');
    }
    public function getPriceByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            // إرجاع عرض صفحة تعرض تفاصيل المنتج وسعره
            return view('products.product-price', compact('product'));
        } else {
            // في حالة عدم العثور على المنتج
            return back()->with('error', 'المنتج غير موجود');
        }
    }



    public function uploadBarcode(Request $request)
    {
        $request->validate([
            'barcode_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // تخزين الصورة المرفوعة
        $path = $request->file('barcode_image')->store('barcodes');

        // قراءة الباركود من الصورة
        $barcode = $this->processBarcodeFromImage($path);

        if (!$barcode) {
            return back()->with('error', 'لم يتم قراءة الباركود من الصورة');
        }

        // البحث عن المنتج بالباركود
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return view('products.product-price', compact('product'));
        } else {
            return back()->with('error', 'لم يتم العثور على المنتج بهذا الباركود');
        }
    }

    private function processBarcodeFromImage($imagePath)
    {
        // تحديد مسار الصورة
        $imageFullPath = storage_path('app/' . $imagePath);

        // استخدام مكتبة ZXing لقراءة الباركود
        $qrReader = new QrReader($imageFullPath);
        $barcode = $qrReader->text(); // قراءة النص من الصورة (الباركود)

        return $barcode; // إذا تم قراءة الباركود بنجاح
    }
}
