@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>إضافة منتج جديد</h4>
                    </div>
                    <div class="card-body">
                        <!-- عرض رسائل النجاح أو الخطأ -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('second-products.store') }}" method="POST">
                            @csrf
                            <!-- اسم المنتج -->
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المنتج</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- عدد العبوات -->
                            <div class="mb-3">
                                <label for="package_count" class="form-label">عدد العبوات</label>
                                <input  name="package_count"
                                    class="form-control @error('package_count') is-invalid @enderror"
                                    value="{{ old('package_count') }}">
                                @error('package_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- عدد الوحدات -->
                            <div class="mb-3">
                                <label for="unit_count" class="form-label">عدد الوحدات</label>
                                <input name="unit_count"
                                    class="form-control @error('unit_count') is-invalid @enderror"
                                    value="{{ old('unit_count') }}" required>
                                @error('unit_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- السعر بالدولار -->
                            <div class="mb-3">
                                <label for="price_usd" class="form-label">السعر بالدولار</label>
                                <input name="price_usd"
                                    class="form-control @error('price_usd') is-invalid @enderror"
                                    value="{{ old('price_usd') }}" step="0.01" required>
                                @error('price_usd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الملاحظات -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">الملاحظات</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">حفظ المنتج</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
