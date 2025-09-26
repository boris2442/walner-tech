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
    //  public function index(Request $request)
    //  {
    //      $query = Product::query()->with('category', 'images'); // images relation si tu as une table images

    // //     // Filtre par recherche si rempli
    //      if ($request->has('search') && $request->search != '') {
    //          $query->where('name', 'like', "%{$request->search}%");
    //      }

    // //     // Filtre par catégorie si demandé
    //      if ($request->has('category') && $request->category != '') {
    //          $query->whereHas('category', function ($q) use ($request) {
    //              $q->where('id', $request->category);
    //          });
    //      }

    //      $products = $query->paginate(70);
      

    //      $categories = Category::all();

    
    //      return Inertia::render('Backend/Products/ProductIndex', [
    //          'products' => $products,
    //          'categories' => $categories,
    //          'filters' => $request->only(['search', 'category']),
    //      ]);
    //  }


//     public function index(Request $request)
// {
//     $query = Product::with(['category', 'images']); // eager loading

//     // Filtre recherche
//     if (!empty($request->search)) {
//         $query->where('title', 'like', "%{$request->search}%");
//     }

//     // Filtre catégorie
//     if (!empty($request->category)) {
//         // Optimisé : pas besoin de whereHas si category_id est déjà dans la table products
//         $query->where('category_id', $request->category);
//     }

//     // Pas de pagination, on récupère tout
//     $products = $query->get();

//     // Comme les catégories sont souvent utilisées, on peut les charger en une seule requête
//     $categories = Category::select('id', 'name')->get();

//     return Inertia::render('Backend/Products/ProductIndex', [
//         'products' => $products,
//         'categories' => $categories,
//         'filters' => $request->only(['search', 'category']),
//     ]);
// }

   



public function index(Request $request)
{
    // On récupère tous les produits avec leurs images et catégorie
    $query = Product::with('category', 'images');

    // Filtre par recherche si rempli
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', "%{$request->search}%");
    }

    // Filtre par catégorie si demandé
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    // On récupère tous les produits (sans pagination)
    $products = $query->get();

    // Récupération des catégories
    $categories = Category::all();

    return Inertia::render('Backend/Products/ProductIndex', [
        'products' => $products,          // renvoie tous les produits
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
            ->with('error', 'Erreur lors de l\'ajout du produit : '.$e->getMessage());
    }
}


}
