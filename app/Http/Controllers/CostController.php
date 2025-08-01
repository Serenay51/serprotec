<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CostController extends Controller
{
    public function index()
    {
        $costs = Cost::with('provider')->latest()->paginate(10);
        return view('costs.index', compact('costs'));
    }

    public function create()
    {
        $providers = Provider::all();
        return view('costs.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'file' => 'required|file|mimes:xlsx,xls,pdf|max:2048',
        ]);

        $path = $request->file('file')->store('costs', 'public');

        Cost::create([
            'provider_id' => $data['provider_id'],
            'file' => $path,
            'filename' => $request->file('file')->getClientOriginalName(),
        ]);

        return redirect()->route('costs.index')->with('success', 'Lista de costos subida correctamente.');
    }

    public function destroy(Cost $cost)
    {
        Storage::disk('public')->delete($cost->file);
        $cost->delete();

        return redirect()->route('costs.index')->with('success', 'Lista de costos eliminada.');
    }

    public function download(Cost $cost)
    {
        $file = Storage::disk('public')->path($cost->file); 
        return response()->download($file, $cost->filename);
    }
}
