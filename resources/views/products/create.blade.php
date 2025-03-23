@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center text-primary mb-5">إضافة منتج جديد</h2>

        <form action="{{ route('products.store') }}" method="POST" class="p-4 shadow-lg rounded-lg bg-light border border-primary">
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label text-dark font-weight-bold">اسم المنتج</label>
                <input type="text" name="name" class="form-control border-2 border-primary p-3" placeholder="أدخل اسم المنتج" required>
            </div>

            <div class="mb-4">
                <label for="price" class="form-label text-dark font-weight-bold">السعر</label>
                <input type="number" name="price" class="form-control border-2 border-primary p-3" placeholder="أدخل السعر" required>
            </div>

            <div class="mb-4">
                <label for="stock" class="form-label text-dark font-weight-bold">المخزون</label>
                <input type="number" name="stock" class="form-control border-2 border-primary p-3" placeholder="أدخل عدد المنتجات المتاحة" required>
            </div>

            <div class="mb-4">
                <label for="barcode" class="form-label text-dark font-weight-bold">الباركود</label>
                <input type="text" name="barcode" class="form-control border-2 border-primary p-3" placeholder="أدخل رقم الباركود" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-gradient btn-success px-5 py-3 mt-4">حفظ المنتج</button>
            </div>
        </form>
    </div>
@endsection
