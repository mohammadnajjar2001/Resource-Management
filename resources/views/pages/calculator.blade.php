@extends('layout.app')

@section('title')
    Calculator
@endsection

@section('content')
    <div style="text-align: center; margin-top: 20px;">
        <iframe src="https://a-calc.info/"
                width="100%"
                height="600px"
                style="border: none;">
        </iframe>
    </div>
@endsection
