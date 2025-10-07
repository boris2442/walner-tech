<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
class DashboardController extends Controller
{
    //  public function index()
    // {
    //     // Répartition des produits par catégorie
    //     $productsByCategory = Category::withCount('products')
    //         ->orderBy('products_count', 'desc')
    //         ->get()
    //         ->map(function($c) {
    //             return [
    //                 'name'  => $c->name,
    //                 'count' => (int) $c->products_count,
    //             ];
    //         });

    //     // tu peux renvoyer d'autres dataset plus tard (users, top_products, ...)
    //     return Inertia::render('backend/admin/Administrateur', [
    //         'products_by_category' => $productsByCategory,
    //     ]);
    // }


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
      

        // dd($productsByCategory);
        return Inertia::render('backend/admin/Administrateur', [
            'products_by_category' => $productsByCategory,
        ]);
    }

}
