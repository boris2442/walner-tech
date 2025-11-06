<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DescriptionRequest;
use Illuminate\Http\Request;
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
    //Delete description
    public function destroy($id)
    {
        $description = DescriptionProduct::findOrFail($id);
        if (!$description) {
            return redirect()->back()
                ->with('flash', [
                    'message' => 'Description introuvable',
                ]);

        }
        $description->delete();
        return redirect()->route('admin.description.index')
            ->with(
                'flash',
                [
                    'message' => 'description supprimée avec succès ✅',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );
    }
    //Edit
    public function edit($id)
    {
        $description = DescriptionProduct::with('product')->findOrFail($id);
        $products = Product::all(); // pour permettre à l’utilisateur de changer le produit si besoin

        return Inertia::render('backend/produits/descriptions/DescriptionProductEdit', [
            'description' => $description,
            'products' => $products,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string',
        ]);

        $description = DescriptionProduct::findOrFail($id);
        $description->update([
            'product_id' => $request->product_id,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('admin.description.index')

            ->with(
                'flash',
                [
                    'message' => 'Description mise à jour avec succès ✅',
                    // 'text' => '',
                    //'href' => route('')
                ]
            );
    }

}
