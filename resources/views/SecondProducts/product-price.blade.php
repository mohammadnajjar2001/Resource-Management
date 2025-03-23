@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>تفاصيل المنتج</h4>
                    </div>
                    <div class="card-body">
                        <!-- عرض رسائل الخطأ -->
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- إذا تم العثور على المنتج -->
                        @if ($product)
                            <div class="mb-4">
                                <h3 class="text-center mb-3">{{ $product->name }}</h3>


                                <div class="col-md-6">
                                    <p><strong>سعر المنتج (بالدولار):</strong> {{ number_format($product->price, 2) }} $</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>سعر المنتج (بالليرة التركية):</strong> {{ number_format($priceInTry, 2) }} ₺
                                    </p>
                                </div>



                                <div class="col-md-6">
                                    <p><strong>سعر المنتج (بالليرة السورية):</strong> {{ $priceInSyp }}
                                        ل.س</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>الكمية المتاحة:</strong> {{ $product->stock }}</p>
                                </div>

                            </div>
                        @else
                            <!-- رسالة في حال عدم العثور على المنتج -->
                            <div class="alert alert-warning text-center">
                                <strong>تنبيه:</strong> لم يتم العثور على المنتج بهذا الباركود.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
