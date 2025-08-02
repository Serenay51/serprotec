<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected $requiredHeaders = ['name', 'category', 'description', 'price', 'stock'];

    public function model(array $row)
    {
        // Validar campos vacíos
        foreach ($this->requiredHeaders as $header) {
            if (!isset($row[$header]) || $row[$header] === null || $row[$header] === '') {
                throw new \Exception("Formato incorrecto: la columna '{$header}' está vacía en alguna fila.");
            }
        }

        return new Product([
            'name'        => $row['name'],
            'category'    => $row['category'],
            'description' => $row['description'],
            'price'       => $row['price'],
            'stock'       => $row['stock'],
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Primera fila como encabezado
    }

    public function validateHeaders(array $headings)
    {
        $missing = array_diff($this->requiredHeaders, $headings);
        if (!empty($missing)) {
            throw new \Exception('Formato incorrecto: faltan columnas (' . implode(', ', $missing) . ').');
        }
    }
}
