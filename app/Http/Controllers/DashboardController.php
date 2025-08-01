<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use App\Models\Cost;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        //Balance ultimo mes (ventas)
        $lastMonthSales = Sale::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->year)
            ->sum('total');

        // Balance del mes (ventas)
        $monthSales = Sale::whereMonth('date', now()->month)->sum('total');

        // Costos del mes (ajusta según tu modelo y columna)
        $monthCosts = Cost::whereMonth('date', now()->month)->sum('total'); // <-- agrega esto

        // Ventas recientes (últimas 5)
        $recentSales = Sale::with('client')->latest()->take(5)->get();

       // 🔥 Vencimientos del día
        $vencimientos = collect();

        $sales = Sale::with(['saleItems.product'])->get();

        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $product = $item->product;

                if (!$product) continue;

                // Determinar fecha de vencimiento según categoría
                $vencimiento = null;
                if (Str::contains(Str::lower($product->category), 'extintores')) {
                    $vencimiento = Carbon::parse($sale->date)->addYear();
                } elseif (Str::contains(Str::lower($product->category), 'indumentaria')) {
                    $vencimiento = Carbon::parse($sale->date)->addMonths(6);
                } elseif (Str::contains(Str::lower($product->category), 'carteleria') ||
                        Str::contains(Str::lower($product->category), 'equipos') ||
                        Str::contains(Str::lower($product->category), 'herramientas')) {
                    $vencimiento = null; // Sin vencimiento
                }

                // Si el vencimiento es HOY, lo agregamos a la colección
                if ($vencimiento && $vencimiento->isSameDay($today)) {
                    $vencimientos->push((object) [
                        'name' => $product->name,
                        'category' => $product->category,
                        'days_left' => $vencimiento->diffInDays($today, false),
                        'sale_number' => $sale->number,
                        'sale_id' => $sale->id,
                        'client_name' => $sale->client->name ?? 'Desconocido',
                        'client_phone' => $sale->client->phone ?? 'No disponible',
                    ]);
                }
            }
        }

        // Totales rápidos
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalProviders = Provider::count();

        //Balance clientes del ultimo mes
        $lastMonthClients = Client::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Balance clientes del mes
        $monthClients = Client::whereMonth('created_at', now()->month)->count();

        return view('dashboard', compact(
            'monthSales',
            'monthCosts', // <-- agrega esto
            'recentSales',
            'vencimientos',
            'totalClients',
            'totalProducts',
            'totalProviders',
            'lastMonthSales',
            'lastMonthClients',
            'monthClients'
        ));
    }
}
