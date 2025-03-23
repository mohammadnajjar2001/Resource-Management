@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <!-- إشعارات العمليات -->
        @if (session('add'))
            <div class="alert alert-success d-flex align-items-center">
                <i class="fa fa-check-circle me-2"></i>
                <span>{{ session('add') }}</span>
            </div>
        @endif
        @if (session('update'))
            <div class="alert alert-info d-flex align-items-center">
                <i class="fa fa-info-circle me-2"></i>
                <span>{{ session('update') }}</span>
            </div>
        @endif
        @if (session('delete'))
            <div class="alert alert-danger d-flex align-items-center">
                <i class="fa fa-exclamation-circle me-2"></i>
                <span>{{ session('delete') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center">
                <i class="fa fa-times-circle me-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- زر إظهار/إخفاء البحث -->
        <button id="toggleFilter" class="btn btn-warning mb-3">
            <i class="fa fa-search search-icon"></i> بحث
        </button>

        <!-- نموذج البحث -->
        <div id="filterTable" style="display: none;">
            <form action="{{ URL::current() }}" method="GET" class="form-control p-3">
                <h3 class="text-center">🔍 البحث في المنتجات</h3>
                <div class="row mb-3">
                    <!-- فلترة العنوان -->
                    <div class="col-md-4">
                        <label for="name">الاسم:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                    </div>
                </div>
                <!-- أزرار البحث والتصفية -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mx-2">🔎 ابحث</button>
                    <a href="{{ URL::current() }}" class="btn btn-info mx-2">🧹 مسح الفلترة</a>
                </div>
            </form>
        </div>

        <h2 class="text-center mb-4">قائمة المنتجات</h2>
        <a href="{{ route('second-products.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الكمية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('second-products.edit', $product) }}" class="btn btn-warning">تعديل</a>
                            <a href="{{ route('second-products.show', $product) }}" class="btn btn-info">عرض</a>
                            <form action="{{ route('second-products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
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
