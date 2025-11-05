<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DescriptionRequest;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\DescriptionProduct;


class DescriptionProductController extends Controller
{

    public function create()
    {
        // Récupérer les produits sans description
        $products = Product::doesntHave('descriptionProduct')->get();

        return Inertia::render('backend/produits/descriptions/DescriptionProduct', [
            'products' => $products,
        ]);
    }





    // Ajouter une description à un produit
    public function store(DescriptionRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Vérifie si une description existe déjà
        if ($product->descriptionProduct) {
            return redirect()->back()->with('flash', [
                'message' => 'Ce produit a déjà une description.',

            ]);
        }

        $validated = $request->validated();
        $validated['product_id'] = $product->id;

        DescriptionProduct::create($validated);

        return redirect()->route('admin.description.index')->with('flash', [
            'message' => 'Description attribuée avec succès !',
        ]);
    }

    public function index()
    {
        $descriptions = DescriptionProduct::with('product')
            ->orderBy('created_at', 'desc') // du plus récent au plus ancien 🔥
            ->get();
        // Nombre total de descriptions existantes
        $totalDescriptions = DescriptionProduct::count();

        // Nombre de produits qui n'ont pas encore de description
        $totalWithoutDescription = Product::doesntHave('descriptionProduct')->count();
        $totalADecrit = $totalWithoutDescription + $totalDescriptions;
        return Inertia::render('backend/produits/descriptions/DescriptionProductIndex', [
            'descriptions' => $descriptions,
            'stats' => [
                'totalDescriptions' => $totalDescriptions,
                'totalWithoutDescription' => $totalWithoutDescription,
                'totalADecrit' => $totalADecrit
            ],
        ]);
    }

}
