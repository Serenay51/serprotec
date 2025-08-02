<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    protected $requiredHeaders = ['name', 'email', 'phone', 'address', 'cuit'];

    public function model(array $row)
    {
        // Validar columnas obligatorias no vacías
        foreach ($this->requiredHeaders as $header) {
            if (!isset($row[$header]) || $row[$header] === null || $row[$header] === '') {
                throw new \Exception("Formato incorrecto: la columna '{$header}' está vacía en alguna fila.");
            }
        }

        return new Client([
            'name'    => $row['name'],
            'email'   => $row['email'],
            'phone'   => $row['phone'],
            'address' => $row['address'],
            'cuit'    => $row['cuit'],
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
