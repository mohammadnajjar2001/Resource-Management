<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // جلب جميع المنتجات مع دعم الفلترة
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();
        $name = $request->query('name');
        $barcode = $request->query('barcode');

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        if ($barcode) {
            $query->where('barcode', 'LIKE', "%{$barcode}%");
        }

        $products = $query->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    // تخزين منتج جديد
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'barcode' => 'required|string|unique:products|max:255',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج بنجاح!',
            'data' => $product
        ], 201);
    }

    // عرض تفاصيل منتج معين
    public function show(Product $product): JsonResponse
    {
        $currencyRate = CurrencyRate::latest()->first();

        if (!$currencyRate) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على أسعار الصرف. الرجاء إضافتها أولاً.'
            ], 404);
        }

        $priceInTry = $product->price * $currencyRate->usd_to_try;
        $priceInSyp = $product->price * $currencyRate->usd_to_syp;

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'price_in_try' => $priceInTry,
                'price_in_syp' => $priceInSyp,
            ]
        ]);
    }

    // تحديث منتج معين
    public function update(Request $request, Product $product)
    {
        // التحقق من صحة البيانات المرسلة فقط
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'barcode' => "string|max:255|unique:products,barcode,{$product->id}",
        ]);

        // تحديث فقط الحقول المرسلة دون تغيير باقي القيم
        $product->update($validatedData);

        return response()->json([
            'message' => 'تم تحديث المنتج بنجاح!',
            'product' => $product
        ]);
    }


    // حذف منتج
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنتج بنجاح!'
        ]);
    }

    // البحث عن المنتج عبر الباركود
    public function getPriceByBarcode(Request $request): JsonResponse
    {
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // رفع صورة باركود والبحث عن المنتج
    // public function uploadBarcode(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'barcode_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $path = $request->file('barcode_image')->store('barcodes');

    //     $barcode = $this->processBarcodeFromImage($path);

    //     if (!$barcode) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'لم يتم قراءة الباركود من الصورة'
    //         ], 400);
    //     }

    //     $product = Product::where('barcode', $barcode)->first();

    //     if (!$product) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'لم يتم العثور على المنتج بهذا الباركود'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $product
    //     ]);
    // }

    // private function processBarcodeFromImage($imagePath): ?string
    // {
    //     $imageFullPath = storage_path('app/' . $imagePath);
    //     $qrReader = new QrReader($imageFullPath);
    //     return $qrReader->text() ?: null;
    // }
}
