@extends('layout.app')

@section('content')
    <div class="container">
        <h2>مسح أو إدخال الباركود للحصول على سعر المنتج</h2>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- اختيار الطريقة للحصول على الباركود -->
        <div>
            <label>اختر طريقة:</label>
            <div>
                <button id="camera-option" class="btn btn-primary">استخدام الكاميرا</button>
                <button id="manual-option" class="btn btn-secondary">إدخال الرقم يدويًا</button>
                <button id="upload-option" class="btn btn-info">رفع صورة الباركود</button>
            </div>
        </div>

        <!-- نموذج إدخال الرقم يدويًا -->
        <div id="manual-input" style="display: none;">
            <form id="manual-form" action="{{ route('products.getPriceByBarcode') }}" method="post">
                @csrf
                <label for="barcode">الرقم الباركود:</label>
                <input type="text" required id="barcode" name="barcode" class="form-control" >
                <button type="submit" class="btn btn-success mt-2">البحث عن المنتج</button>
            </form>
        </div>


        <!-- نموذج رفع صورة الباركود -->
        <div id="upload-input" style="display: none;">
            <form id="upload-form" action="{{ route('products.uploadBarcode') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="barcode-image">رفع صورة الباركود:</label>
                <input type="file" required id="barcode-image" name="barcode_image" accept="image/*" class="form-control">
                <button type="submit" class="btn btn-success mt-2">رفع الصورة</button>
            </form>
        </div>

        <!-- عنصر لعرض كاميرا الجهاز -->
        <div id="scanner-container" style="display: none;">
            <div id="interactive" class="viewport"></div>
        </div>

        <form id="barcode-form" action="{{ route('products.getPriceByBarcode') }}" method="GET" style="display: none;">
            <input type="text" id="barcode" name="barcode">
            <button type="submit">البحث عن المنتج</button>
        </form>
    </div>

    <script>
        // إخفاء جميع المدخلات في البداية
        document.getElementById('manual-input').style.display = 'none';
        document.getElementById('upload-input').style.display = 'none';
        document.getElementById('scanner-container').style.display = 'none';

        // اختيار الطريقة باستخدام الكاميرا
        document.getElementById('camera-option').addEventListener('click', function() {
            document.getElementById('scanner-container').style.display = 'block';
            document.getElementById('manual-input').style.display = 'none';
            document.getElementById('upload-input').style.display = 'none';
            initScanner();
        });

        // اختيار الطريقة باستخدام الرقم يدويًا
        document.getElementById('manual-option').addEventListener('click', function() {
            document.getElementById('scanner-container').style.display = 'none';
            document.getElementById('manual-input').style.display = 'block';
            document.getElementById('upload-input').style.display = 'none';
        });

        // اختيار الطريقة باستخدام رفع صورة
        document.getElementById('upload-option').addEventListener('click', function() {
            document.getElementById('scanner-container').style.display = 'none';
            document.getElementById('manual-input').style.display = 'none';
            document.getElementById('upload-input').style.display = 'block';
        });

        // إعداد QuaggaJS لمسح الباركود باستخدام كاميرا الجهاز
        function initScanner() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                Quagga.init({
                    inputStream: {
                        name: 'Live',
                        type: 'LiveStream',
                        target: document.querySelector('#interactive'), // العنصر الذي سيتم عرض الفيديو عليه
                    },
                    decoder: {
                        readers: ['ean_reader', 'upc_reader', 'code_128_reader'] // القارئ المناسب للباركود
                    }
                }, function(err) {
                    if (err) {
                        console.log(err);
                        return;
                    }

                    // بدء الكاميرا
                    Quagga.start();

                    // معالجة عملية المسح
                    Quagga.onDetected(function(result) {
                        var barcode = result.codeResult.code;
                        document.getElementById('barcode').value = barcode;
                        document.getElementById('barcode-form').submit(); // إرسال النموذج مباشرة
                    });
                });
            } else {
                alert('كاميرا الجهاز غير مدعومة.');
            }
        }
    </script>
@endsection
