<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{




    // public function index(Request $request)
// {
//     // On récupère tous les produits avec leurs images et catégorie
//     $query = Product::with('category', 'images');

    //     // Filtre par recherche si rempli
//     if ($request->has('search') && $request->search != '') {
//         $query->where('title', 'like', "%{$request->search}%");
//     }

    //     // Filtre par catégorie si demandé
//     if ($request->has('category') && $request->category != '') {
//         $query->where('category_id', $request->category);
//     }

    //     // On récupère tous les produits (sans pagination)
//     $products = $query->get();

    //     // Récupération des catégories
//     $categories = Category::all();

    //     return Inertia::render('Backend/Products/ProductIndex', [
//         'products' => $products,          // renvoie tous les produits
//         'categories' => $categories,      // toutes les catégories
//         'filters' => $request->only(['search', 'category']),
//     ]);
// }


    public function index(Request $request)
    {
        // On récupère tous les produits avec leurs images, catégorie et compteur de likes
        $query = Product::with(['category', 'images'])
            ->withCount('likes');

        // Filtre par recherche si rempli
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Filtre par catégorie si demandé
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // On récupère tous les produits (sans pagination)
        $products = $query->get()->map(function ($product) {
            $product->liked = auth()->check()
                ? $product->likes()->where('user_id', auth()->id())->exists()
                : false;
            return $product;
        });

        // Récupération des catégories
        $categories = Category::all();

        return Inertia::render('Backend/Products/ProductIndex', [
            'products' => $products,          // renvoie tous les produits avec likes_count + liked
            'categories' => $categories,      // toutes les catégories
            'filters' => $request->only(['search', 'category']),
        ]);
    }




    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Backend/Products/ProductCreate', compact('categories'));
    }


    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Stocker l'image dans storage/app/public/imageProducts
                    $path = $image->store('imageProducts', 'public');

                    // Vérifier que le fichier existe physiquement
                    if (!file_exists(storage_path('app/public/' . $path))) {
                        throw new \Exception("Le fichier n'a pas été stocké correctement");
                    }

                    // Enregistrer le chemin dans la DB
                    $product->images()->create(['url_image' => $path]);
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Produit ajouté avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'ajout du produit : ' . $e->getMessage());
        }
    }


}
