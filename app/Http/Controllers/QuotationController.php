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
    public function index(Request $request)
    {
        $query = Quotation::with('client');

        // Buscar por nombre cliente o número de presupuesto (quotation)
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('number', 'LIKE', "%{$search}%");
            });
        }

        // Filtrar por rango de fechas
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('date', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('date', '<=', $dateTo);
        }

        $quotations = $query->orderBy('date', 'desc')->paginate(10);

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
