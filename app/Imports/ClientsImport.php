<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Client([
            'name'    => $row['name'],
            'email'   => $row['email'] ?? null,
            'phone'   => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'cuit'    => $row['cuit'] ?? null,
        ]);
    }
}
