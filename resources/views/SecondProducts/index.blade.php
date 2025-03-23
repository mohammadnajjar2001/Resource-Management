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
                    <div class="col-md-4">
                        <label for="name">الاسم:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ request('name') }}">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mx-2">🔎 ابحث</button>
                    <a href="{{ URL::current() }}" class="btn btn-info mx-2">🧹 مسح الفلترة</a>
                </div>
            </form>
        </div>

        <h2 class="text-center mb-4">قائمة المنتجات</h2>
        <a href="{{ route('second-products.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>
        <!-- زر استيراد Excel -->
        <button class="btn btn-success mb-3" onclick="document.getElementById('importExcel').click();">
            📥 استيراد من Excel
        </button>

        <!-- نموذج رفع ملف Excel -->
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="file" id="importExcel" name="excel_file" accept=".xlsx, .xls" onchange="this.form.submit();">
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>العدد بالطرد</th>
                    <th>العدد بالقطعة</th>
                    <th>السعر بالدولار</th>
                    <th>المجموع</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->package_count ?? 'غير متوفر' }}</td>
                        <td>{{ $product->unit_count }}</td>
                        <td>${{ number_format($product->price_usd, 2) }}</td>
                        <td>
                            @php
                                $package_count = $product->package_count > 0 ? $product->package_count : 1;
                                $unit_count = $product->unit_count;
                                $price_usd = $product->price_usd;

                                $total = $package_count * $unit_count * $price_usd;
                            @endphp
                            {{ '$' . number_format($total, 2) }}
                        </td>


                        <td>
                            <a href="{{ route('second-products.edit', $product) }}" class="btn btn-warning">تعديل</a>
                            <a href="{{ route('second-products.show', $product) }}" class="btn btn-info">عرض</a>

                            <!-- زر الحذف -->
                            <form action="{{ route('second-products.destroy', $product) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                            </form>

                            <!-- زر السلة لتقليل عدد الوحدات -->
                            <form action="{{ route('second-products.reducePlus', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-dash-circle"></i>
                                </button>
                            </form>
                            <!-- زر السلة لزيادة عدد الوحدات -->
                            <form action="{{ route('second-products.reduceMinus', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
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
        // إظهار/إخفاء نموذج البحث
        document.getElementById('toggleFilter').addEventListener('click', function() {
            const filterTable = document.getElementById('filterTable');
            filterTable.style.display = (filterTable.style.display === 'none') ? 'block' : 'none';
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.reduce-unit').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.getAttribute('data-id');

                    fetch(`/second-products/${productId}/reduce-unit`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                });
            });
        });
    </script>
@endpush
