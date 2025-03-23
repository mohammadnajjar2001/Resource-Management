@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <!-- إشعارات العمليات -->
        <div class="alert-container mb-4">
            @if (session('add'))
                <div class="alert alert-success d-flex align-items-center shadow-sm p-3 mb-2 rounded">
                    <i class="bi bi-check-circle me-2"></i>{{ session('add') }}
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-info d-flex align-items-center shadow-sm p-3 mb-2 rounded">
                    <i class="bi bi-pencil-square me-2"></i>{{ session('update') }}
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-danger d-flex align-items-center shadow-sm p-3 mb-2 rounded">
                    <i class="bi bi-x-circle me-2"></i>{{ session('delete') }}
                </div>
            @endif
        </div>

        <h2 class="text-center text-primary mb-5 font-weight-bold">سعر الصرف الحالي</h2>

        @if ($currencyRate)
            <div class="card shadow-sm mb-4 p-4">
                <h4 class="card-title text-success">سعر الصرف الحالي:</h4>
                <p><strong>الدولار إلى الليرة التركية:</strong> {{ $currencyRate->usd_to_try }} ₺</p>
                <p><strong>الدولار إلى الليرة السورية:</strong> {{ $currencyRate->usd_to_syp }} ل.س</p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('currency_rates.edit') }}" class="btn btn-primary">تعديل سعر الصرف</a>
                </div>
            </div>
        @else
            <div class="alert alert-warning mb-4 p-4 rounded shadow-sm">
                <p>لم يتم تسجيل سعر صرف بعد.</p>
                <a href="{{ route('currency_rates.create') }}" class="btn btn-success">إضافة سعر صرف جديد</a>
            </div>
        @endif
    </div>
@endsection
