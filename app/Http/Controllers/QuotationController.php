<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('client')->latest()->paginate(10);
        return view('quotations.index', compact('quotations'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('quotations.create', compact('clients', 'products'));
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


        $quotation = Quotation::create([
            'client_id' => $data['client_id'],
            'number' => 'P-' . str_pad(Quotation::count() + 1, 4, '0', STR_PAD_LEFT),
            'date' => $data['date'],
            'total' => 0,
        ]);

        $total = 0;
        foreach ($data['items'] as $item) {
            $subtotal = $item['quantity'] * $item['price'];
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);
            $total += $subtotal;
        }

        $quotation->update(['total' => $total]);

        return redirect()->route('quotations.index')->with('success', 'Presupuesto creado.');
    }

    public function pdf(Quotation $quotation)
    {
        $quotation->load('client', 'items.product');
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))->setPaper('A4');
        return $pdf->download($quotation->number.'.pdf');
    }

    public function show(Quotation $quotation)
    {
        $quotation->load('client', 'items.product');
        return view('quotations.show', compact('quotation'));
    }

}
