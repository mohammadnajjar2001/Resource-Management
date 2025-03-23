<?php

namespace App\Imports;

use App\Models\SecondProduct;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SecondProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return SecondProduct::create([
            'name'          => $row['name'] ?? null,
            'package_count' => isset($row['package_count']) ? (int) $row['package_count'] : null,
            'unit_count'    => isset($row['unit_count']) ? (float) $row['unit_count'] : 0,
            'price_usd'     => isset($row['price_usd']) ? (float) $row['price_usd'] : 0,
            'notes'         => $row['notes'] ?? null,
        ]);
    }
}

