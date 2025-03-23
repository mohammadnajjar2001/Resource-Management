<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' =>  'maohammed najjar',
            'email' => 'a@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        // إضافة 5 منتجات إلى الجدول
        Product::create([
            'name' => 'أندومي كبير',
            'price' => 0.40,
            'stock' => 50,
            'barcode' => '123456789012',
        ]);

        Product::create([
            'name' => 'مرتديلا هنا',
            'price' => 0.67,
            'stock' => 30,
            'barcode' => '987654321098',
        ]);

        Product::create([
            'name' => 'أندومي صغير',
            'price' => 0.32,
            'stock' => 20,
            'barcode' => '456789012345',
        ]);
    }
}
