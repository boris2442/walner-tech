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

        return Inertia::render('backend/products/ProductIndex', [
            'products' => $products,          // renvoie tous les produits avec likes_count + liked
            'categories' => $categories,      // toutes les catégories
            'filters' => $request->only(['search', 'category']),
        ]);
    }




    public function create()
    {
        $categories = Category::all();
        return Inertia::render('backend/products/ProductCreate', compact('categories'));
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

            return redirect()->route('products.index')
                ->with('success', 'Produit ajouté avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'ajout du produit : ' . $e->getMessage());
        }
    }


    public function indexBackend(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(50)->withQueryString();

        // Stats
        $totalProducts = Product::count();
        $addedThisWeek = Product::where('created_at', '>=', now()->startOfWeek())->count();
        $productsByCategory = Product::select('category_id')
            ->selectRaw('count(*) as count')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Toutes les catégories pour le filtre
        $categories = Category::all();

        return Inertia::render('backend/produits/Index', [
            'products' => $products,
            'stats' => [
                'total' => $totalProducts,
                'addedThisWeek' => $addedThisWeek,
                'byCategory' => $productsByCategory,
            ],
            'filters' => $request->only(['search', 'category']),
            'categories' => $categories, // 🔑 On envoie cette prop
        ]);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'produits introuvable.');
        }

        $product->delete();

        // Redirection compatible Inertia
        return Inertia::location(route('products.index'));
    }


    // Formulaire d'édition
    public function edit(Product $product)
    {
        $categories = Category::all();
        return inertia('backend/produits/Edit', [
            'product' => $product->load('images'),
            'categories' => $categories,
        ]);
    }

    // Mise à jour du produit
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:disponible,indisponible',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $product->update($validated);

        // Gestion des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['url_image' => $path]);
            }
        }

        return redirect()->route('products.index', $product->id)
            ->with('success', 'Produit mis à jour avec succès');
    }
}
