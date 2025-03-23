@extends('layout.app')

@section('content')
    <div class="container">

        <!-- إشعارات العمليات -->
        @if (session('add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>نجاح!</strong> {{ session('add') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('update'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>تم التحديث!</strong> {{ session('update') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>تم الحذف!</strong> {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>خطأ!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- زر إظهار/إخفاء البحث -->
        <button id="toggleFilter" class="btn btn-warning mb-3">
            <i class="fa fa-search"></i> بحث
        </button>

        <!-- نموذج البحث -->
        <div id="filterTable" style="display: none;">
            <form action="{{ URL::current() }}" method="GET" class="form-control p-3 border rounded">
                <h3 class="text-center mb-3">🔍 البحث في المنتجات</h3>
                <div class="row mb-3">
                    <!-- فلترة العنوان -->
                    <div class="col-md-4">
                        <label for="name">الاسم:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                    </div>

                    <!-- فلترة المحتوى -->
                    <div class="col-md-4">
                        <label for="barcode">باركود:</label>
                        <input type="text" name="barcode" id="barcode" class="form-control"
                            value="{{ request('barcode') }}">
                    </div>
                </div>
                <!-- أزرار البحث والتصفية -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mx-2">🔎 ابحث</button>
                    <a href="{{ URL::current() }}" class="btn btn-info mx-2">🧹 مسح الفلترة</a>
                </div>
            </form>
        </div>

        <!-- عنوان المنتجات -->
        <h2 class="mt-4 mb-3 text-center">قائمة المنتجات</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>

        <!-- جدول المنتجات -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>المتوفر</th>
                    <th>الباركود</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock}}</td>
                        <td>{!! DNS1D::getBarcodeHTML("$product->barcode", 'PHARMA', 0.75, 50) !!}
                            {{ $product->barcode }}
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-success btn-sm">عرض</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        // إظهار/إخفاء جدول البحث
        document.getElementById('toggleFilter').addEventListener('click', function() {
            const filterTable = document.getElementById('filterTable');
            filterTable.style.display = (filterTable.style.display === 'none') ? 'block' : 'none';
        });
    </script>
@endpush
