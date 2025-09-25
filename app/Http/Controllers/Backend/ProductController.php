<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->get();
        return Inertia::render('Backend/Products/ProductIndex', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Backend/Products/ProductCreate', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            // Création du produit
            $product = Product::create($request->validated());

            // Gestion des images multiples
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/imageProducts'); // storage/app/public/imageProducts
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url_image' => Storage::url($path), // pour récupérer l'URL publique
                    ]);
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Produit ajouté avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l’ajout du produit.');
        }
    }
}
