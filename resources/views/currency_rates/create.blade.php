@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center text-primary mb-4">إضافة سعر صرف جديد</h2>

        <form action="{{ route('currency_rates.store') }}" method="POST" class="shadow-sm p-4 rounded border">
            @csrf

            <div class="mb-3">
                <label for="usd_to_try" class="form-label">الدولار إلى الليرة التركية</label>
                <input  name="usd_to_try" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="usd_to_syp" class="form-label">الدولار إلى الليرة السورية</label>
                <input  name="usd_to_syp" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">إضافة سعر الصرف</button>
                <a href="{{ route('currency_rates.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
