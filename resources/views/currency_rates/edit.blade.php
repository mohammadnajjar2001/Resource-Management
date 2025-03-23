@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">تعديل سعر الصرف</h2>

    <form action="{{ route('currency_rates.update') }}" method="POST" class="shadow-sm p-4 rounded border">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="usd_to_try" class="form-label">الدولار إلى الليرة التركية</label>
            <input type="number" step="1" name="usd_to_try" class="form-control" value="{{ $currencyRate->usd_to_try }}" required>
        </div>

        <div class="mb-3">
            <label for="usd_to_syp" class="form-label">الدولار إلى الليرة السورية</label>
            <input type="number" step="10" name="usd_to_syp" class="form-control" value="{{ $currencyRate->usd_to_syp }}" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
        </div>
    </form>
</div>
@endsection
