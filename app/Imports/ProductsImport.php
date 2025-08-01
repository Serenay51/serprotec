<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name'        => $row['name'],
            'category'   => $row['category'],
            'description' => $row['description'],
            'price'      => $row['price'],
            'stock'      => $row['stock'],
        ]);
    }
}