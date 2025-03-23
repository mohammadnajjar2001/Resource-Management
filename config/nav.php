<?php

return [
    [
        'icon' => 'bi bi-house',
        'title' => 'الصفحة الرئيسية',
        'route' => 'dashboard',
    ],
    [
        'icon' => 'bi bi-plus-square-fill',
        'title' => 'إضافة منتج جديد بباركود',
        'route' => 'products.create',
    ],
    [
        'icon' => 'bi bi-eye',
        'title' => 'عرض جميع المنتجات باركود',
        'route' => 'products.index',
    ],
    [
        'icon' => 'bi bi-plus-square-fill',
        'title' => 'إضافة منتج جديد ',
        'route' => 'second-products.create',
    ],
    [
        'icon' => 'bi bi-eye',
        'title' => 'عرض جميع المنتجات ',
        'route' => 'second-products.index',
    ],
    [
        'icon' => 'bi bi-upc-scan',
        'title' => 'مسح باركود للحصول على سعر المنتج',
        'route' => 'products.scanBarcode',
    ],
    [
        'icon' => 'bi bi-coin',
        'title' => ' سعر الصرف ',
        'route' => 'currency_rates.index',
    ],
    [
        'icon' => 'bi bi-calculator',
        'title' => 'الحاسبة',
        'route' => 'calculator',
    ],
    [
        'icon' => 'bi bi-person',
        'title' => 'الحساب',
        'route' => 'profile.edit',
    ],

];
