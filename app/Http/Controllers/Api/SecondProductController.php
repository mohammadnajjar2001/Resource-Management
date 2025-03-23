<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use App\Models\SecondProduct;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SecondProductController extends Controller
{
    // جلب جميع المنتجات مع دعم الفلترة
    public function index(Request $request): JsonResponse
    {
        $query = SecondProduct::query();
        $name = $request->query('name');

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        $SecondProducts = $query->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $SecondProducts
        ]);
    }

    // تخزين منتج جديد
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $SecondProduct = SecondProduct::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج بنجاح!',
            'data' => $SecondProduct
        ], 201);
    }

    // عرض تفاصيل منتج معين
    public function show(SecondProduct $SecondProduct): JsonResponse
    {
        $currencyRate = CurrencyRate::latest()->first();

        if (!$currencyRate) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على أسعار الصرف. الرجاء إضافتها أولاً.'
            ], 404);
        }

        $priceInTry = $SecondProduct->price * $currencyRate->usd_to_try;
        $priceInSyp = $SecondProduct->price * $currencyRate->usd_to_syp;

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $SecondProduct,
                'price_in_try' => $priceInTry,
                'price_in_syp' => $priceInSyp,
            ]
        ]);
    }

    // تحديث منتج معين
    public function update(Request $request, SecondProduct $SecondProduct)
    {
        // التحقق من صحة البيانات المرسلة فقط
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        // تحديث فقط الحقول المرسلة دون تغيير باقي القيم
        $SecondProduct->update($validatedData);

        return response()->json([
            'message' => 'تم تحديث المنتج بنجاح!',
            'second-product' => $SecondProduct
        ]);
    }


    // حذف منتج
    public function destroy(SecondProduct $SecondProduct): JsonResponse
    {
            $SecondProduct->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج بنجاح!'
            ]);
    }
}
