<?php

namespace Database\Seeders;

use App\Models\SecondProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إضافة 5 منتجات إلى الجدول
        SecondProduct::create([
            'name' => 'تمر',
            'price' => 1.6,
            'stock' => 4,
        ]);

        SecondProduct::create([
            'name' => 'فستق',
            'price' => 2.4,
            'stock' => 30,
        ]);

        SecondProduct::create([
            'name' => 'بزر',
            'price' => 1.33,
            'stock' => 20,
        ]);
    }
}
