@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">تفاصيل المنتج</h2>

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center">
                <i class="fa fa-exclamation-circle me-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($product)
            <div class="card mb-4">
                <div class="card-header text-center">
                    <h3>{{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>سعر المنتج (بالدولار):</strong> {{ number_format($product->price, 2) }} $</p>
                    <p><strong>سعر المنتج (بالليرة التركية):</strong> {{ number_format($priceInTry, 2) }} ₺</p>
                    <p><strong>سعر المنتج (بالليرة السورية):</strong> {{ $priceInSyp}} ل.س</p>
                    <p><strong>الكمية المتاحة:</strong> {{ $product->stock }}</p>
                    <p><strong>الباركود:</strong> {{ $product->barcode }}</p>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                <strong>تنبيه:</strong> لم يتم العثور على المنتج بهذا الباركود.
            </div>
        @endif
    </div>
@endsection
