@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>تعديل المنتج</h4>
                    </div>
                    <div class="card-body">
                        <!-- عرض رسائل النجاح أو الخطأ -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- نموذج التعديل -->
                        <form action="{{ route('second-products.update', $SecondProduct->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- اسم المنتج -->
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المنتج</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $SecondProduct->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- سعر المنتج -->
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر</label>
                                <input type="number" id="price" name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $SecondProduct->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الكمية المتوفرة -->
                            <div class="mb-3">
                                <label for="stock" class="form-label">المخزون</label>
                                <input type="number" id="stock" name="stock"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', $SecondProduct->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">تحديث المنتج</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
