<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::latest()->paginate(10);
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'cuit' => 'nullable|string|max:20',
        ]);
        Provider::create($data);
        return redirect()->route('providers.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'cuit' => 'nullable|string|max:20',
        ]);
        $provider->update($data);
        return redirect()->route('providers.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index')->with('success', 'Proveedor eliminado.');
    }
}
