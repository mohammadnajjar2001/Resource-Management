@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">تعديل المنتج</h1>

        <!-- عرض رسائل النجاح أو الخطأ -->
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center shadow-sm p-3 mb-4 rounded">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- نموذج التعديل -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="shadow-lg p-4 rounded-lg bg-light border border-primary">
            @csrf
            @method('PUT')

            <!-- اسم المنتج -->
            <div class="form-group mb-4">
                <label for="name" class="form-label text-dark font-weight-bold">اسم المنتج</label>
                <input type="text" id="name" name="name" class="form-control border-2 border-primary p-3" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- سعر المنتج -->
            <div class="form-group mb-4">
                <label for="price" class="form-label text-dark font-weight-bold">السعر</label>
                <input type="number" id="price" name="price" class="form-control border-2 border-primary p-3" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- الكمية المتوفرة -->
            <div class="form-group mb-4">
                <label for="stock" class="form-label text-dark font-weight-bold">المخزون</label>
                <input type="number" id="stock" name="stock" class="form-control border-2 border-primary p-3" value="{{ old('stock', $product->stock) }}" required>
                @error('stock')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- بار كود المنتج -->
            <div class="form-group mb-4">
                <label for="barcode" class="form-label text-dark font-weight-bold">الباركود</label>
                <input type="text" id="barcode" name="barcode" class="form-control border-2 border-primary p-3" value="{{ old('barcode', $product->barcode) }}">
                @error('barcode')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-5 py-3 mt-4">تحديث المنتج</button>
            </div>
        </form>
    </div>
@endsection
