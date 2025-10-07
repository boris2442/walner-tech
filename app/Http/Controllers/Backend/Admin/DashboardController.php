<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\OrderClick;
class DashboardController extends Controller
{

    public function index()
    {
        $productsByCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get()
            ->map(function ($c) {
                return [
                    'name' => $c->name,
                    'count' => (int) $c->products_count,
                ];
            });
        // Graphe 3 : évolution des utilisateurs (par jour)
        $usersOverTime = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($u) => [
                'date' => $u->date,
                'count' => (int) $u->count,
            ]);


        // Graphe 4 : messages reçus récemment (7 derniers jours)
        // Messages reçus sur les 7 derniers jours
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $count = Contact::whereDate('created_at', $day)->count();
            $last7Days->push([
                'date' => $day->format('Y-m-d'),
                'count' => $count,
            ]);
        }
        $totalMessages = $last7Days->sum('count');





        // Graphe 4 : clics sur "Commander" par produit
        $ordersByProduct = Product::withCount('orderClicks')
            ->orderBy('order_clicks_count', 'desc')
            ->get()
            ->map(function ($p) {
                return [
                    'name' => $p->title,
                    'count' => (int) $p->order_clicks_count,
                ];
            });


        // Graphe : commandes par mois
        // $ordersByMonth = OrderClick::select(
        //     DB::raw('MONTH(created_at) as month'),
        //     DB::raw('COUNT(*) as count')
        // )
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get()
        //     ->map(function ($item) {
        //         return [
        //             'month' => Carbon::create()->month($item->month)->format('F'),
        //             'count' => $item->count,
        //         ];
        //     });

        // Graphe : commandes par mois
        $rawOrders = OrderClick::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Créer une collection avec les 12 mois de l’année
        $ordersByMonth = collect(range(1, 12))->map(function ($m) use ($rawOrders) {
            $monthData = $rawOrders->firstWhere('month', $m);
            return [
                'month' => Carbon::create()->month($m)->translatedFormat('F'), // nom du mois en français
                'count' => $monthData ? $monthData->count : 0,
            ];
        });


        // Graphe 6 : clics par jour de la semaine (7 derniers jours)
        // $clicksByWeekday = collect();
        // for ($i = 6; $i >= 0; $i--) {
        //     $day = Carbon::today()->subDays($i);
        //     $count = OrderClick::whereDate('created_at', $day)->count();
        //     $clicksByWeekday->push([
        //         'day' => $day->format('l'), // Lundi, Mardi, ...
        //         'count' => $count,
        //     ]);
        // }

        // Graphe 6 : clics par jour de la semaine (7 derniers jours)
        $clicksLast7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $count = OrderClick::whereDate('created_at', $day)->count();

            $clicksLast7Days->push([
                'date' => $day->format('Y-m-d'), // format standard pour le JSON
                'count' => $count,
            ]);
        }



        // dd($productsByCategory);
        return Inertia::render('backend/admin/Administrateur', [
            'products_by_category' => $productsByCategory,
            'users_over_time' => $usersOverTime,
            'total_messages' => $totalMessages,
            'last7Days' => $last7Days,       // ✅ ajouter ici
            'orders_by_product' => $ordersByProduct, // ✅ nouveau graphe
            'orders_by_month' => $ordersByMonth,
            'clicks_last_7_days' => $clicksLast7Days->toArray(),
        ]);
    }

}
