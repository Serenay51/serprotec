<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('client')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('sales.create', compact('clients', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $sale = Sale::create([
            'client_id' => $data['client_id'],
            'number' => 'V-' . str_pad(Sale::count() + 1, 4, '0', STR_PAD_LEFT),
            'date' => \Carbon\Carbon::parse($data['date'])->format('Y-m-d'),
            'total' => 0,
        ]);

        $total = 0;
        foreach ($data['items'] as $item) {
            $subtotal = $item['quantity'] * $item['price'];

            // Descontar stock
            $product = Product::find($item['product_id']);
            if ($product->stock < $item['quantity']) {
                return back()->withErrors(['stock' => "Stock insuficiente para {$product->name}"]);
            }
            $product->decrement('stock', $item['quantity']);

            // Calcular vencimiento automático
            $expiration = null;
            $productCategory = Str::lower($product->category);
            $saleDate = Carbon::parse($data['date']);

            if (Str::contains($productCategory, 'extintores')) {
                $expiration = $saleDate->copy()->addYear();
            } elseif (Str::contains($productCategory, 'indumentaria')) {
                $expiration = $saleDate->copy()->addMonths(6);
            }

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
                'expiration_date' => $expiration ?? null,
            ]);
            $total += $subtotal;
        }

        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
    }

    public function destroy(Sale $sale)
    {
        foreach ($sale->saleItems ?? [] as $item) {
            $product = Product::find($item->product_id);
            $product->increment('stock', $item->quantity);
            $item->delete();
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function show(Sale $sale)
    {
        $sale->load('client', 'saleItems.product');
        return view('sales.show', compact('sale'));
    }
}
