<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use App\Models\Cost;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Balance último mes (ventas)
        $lastMonthSales = Sale::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->year)
            ->sum('total');

        // Cantidad de ventas del último mes
        $lastMonthSalesCount = Sale::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->year)
            ->count();

        // Balance del mes (ventas)
        $monthSales = Sale::whereMonth('date', now()->month)->sum('total');

        // Cantidad de ventas del mes
        $monthSalesCount = Sale::whereMonth('date', now()->month)->count();

        // Costos del mes
        $monthCosts = Cost::whereMonth('date', now()->month)->sum('total');

        // Ventas recientes (últimas 5)
        $recentSales = Sale::with('client')->latest()->take(5)->get();

        // 🔥 Vencimientos del MES
        $vencimientos = collect();

        $sales = Sale::with(['saleItems.product', 'client'])->get();

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

                // Filtrar vencimientos del mes actual
                if ($vencimiento && $vencimiento->month == $today->month && $vencimiento->year == $today->year) {
                    $vencimientos->push((object) [
                        'name' => $product->name,
                        'category' => $product->category,
                        'days_left' => $vencimiento->diffInDays($today, false),
                        'vencimiento' => $vencimiento,
                        'sale_number' => $sale->number,
                        'sale_id' => $sale->id,
                        'client_name' => $sale->client->name ?? 'Desconocido',
                        'client_phone' => $sale->client->phone ?? 'No disponible',
                    ]);
                }
            }
        }

        // Ordenar por fecha de vencimiento ascendente
        $vencimientos = $vencimientos->sortBy('vencimiento');

        // ✅ Paginación manual (5 por página)
        $page = request()->get('page', 1);
        $perPage = 5;
        $vencimientosPaginated = new LengthAwarePaginator(
            $vencimientos->forPage($page, $perPage),
            $vencimientos->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Totales rápidos
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalProviders = Provider::count();
        $totalSales = Sale::sum('total');

        // Balance clientes del último mes
        $lastMonthClients = Client::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Balance clientes del mes actual
        $monthClients = Client::whereMonth('created_at', now()->month)->count();

        // 🏆 Top productos vendidos (ranking)
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 🏅 Logros desbloqueables
        $achievements = [
            [
                'title' => '🔥 10 ventas en el mes',
                'unlocked' => $monthSales >= 10,
                'desc' => 'Alcanzaste 10 ventas este mes.'
            ],
            [
                'title' => '🎯 Meta de $100.000 en ventas',
                'unlocked' => $monthSales >= 100000,
                'desc' => 'Superaste la meta de facturación mensual.'
            ],
            [
                'title' => '🤝 5 clientes nuevos',
                'unlocked' => $monthClients >= 5,
                'desc' => 'Conseguiste 5 clientes nuevos este mes.'
            ],
            [
                'title' => '📦 20 productos vendidos',
                'unlocked' => $monthSalesCount >= 20,
                'desc' => 'Alcanzaste 20 productos vendidos este mes.'
            ],
            [
                'title' => '📈 Crecimiento del 50% en ventas',
                'unlocked' => $lastMonthSales > 0 && ($monthSales / $lastMonthSales) >= 1.5,
                'desc' => 'Tus ventas crecieron un 50% respecto al mes pasado.'
            ],
            [
                'title' => '🌟 Top vendedor del mes',
                'unlocked' => $monthSalesCount >= 30,
                'desc' => 'Eres el top vendedor del mes con más de 30 ventas.'
            ],
        ];

        return view('dashboard', compact(
            'monthSales',
            'monthCosts',
            'recentSales',
            'vencimientosPaginated',
            'totalClients',
            'totalProducts',
            'totalProviders',
            'lastMonthSales',
            'lastMonthClients',
            'monthClients',
            'lastMonthSalesCount',
            'monthSalesCount',
            'totalSales',
            'topProducts',
            'achievements'
        ));
    }
}
