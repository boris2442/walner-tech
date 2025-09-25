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
    public function index(Request $request)
    {
        $query = Product::query()->with('category', 'images'); // images relation si tu as une table images

        // Filtre par recherche si rempli
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filtre par catégorie si demandé
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $products = $query->paginate(20);

        $categories = Category::all();

        // return Inertia::render('Backend/Products/ProductIndex', compact('products'));

        return Inertia::render('Backend/Products/ProductIndex', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Backend/Products/ProductCreate', compact('categories'));
    }

    // public function store(ProductRequest $request)
    // {
    //     try {
    //         $product = Product::create($request->validated());


    //         if ($request->hasFile('images')) {
    //             foreach ($request->file('images') as $image) {
    //                 $path = $image->store('imageProducts', 'public');
    //                 $product->images()->create(['url_image' => $path]);
    //             }
    //         }
    //         dd($path, $image);

       
    //         return redirect()->route('admin.products.index')
    //             ->with('success', 'Produit ajouté avec succès !');

    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->with('error', 'Erreur lors de l\'ajout du produit.');
    //     }
    // }

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
            ->with('error', 'Erreur lors de l\'ajout du produit : '.$e->getMessage());
    }
}


}
