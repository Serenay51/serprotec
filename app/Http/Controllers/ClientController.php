<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientsImport;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'cuit' => 'nullable|string'
        ]);

        Client::create($data);

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'cuit' => 'nullable|string'
        ]);

        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $import = new ClientsImport();
            $file = $request->file('file');

            // Validar encabezados antes de importar
            $headings = Excel::toArray($import, $file)[0][0] ?? [];
            $import->validateHeaders(array_keys($headings));

            // Importar archivo
            Excel::import($import, $file);

            return redirect()->route('clients.index')->with('success', 'Clientes importados correctamente.');
        } catch (\Exception $e) {
            // Si hubo error (columnas faltantes o datos vacíos), redirigir con mensaje de error
            return redirect()->route('clients.index')->with('import_error', $e->getMessage());
        }
    }
}
