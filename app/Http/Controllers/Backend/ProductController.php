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
                    // Générer un nom unique
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Déplacer le fichier directement dans public/imageProducts/
                    $image->move(public_path('imageProducts'), $filename);

                    // Enregistrer le chemin relatif dans la base
                    $product->images()->create([
                        'url_image' => 'imageProducts/' . $filename,
                    ]);
                }
            }

            return redirect()->route('products.index')
                //->with('success', 'Produit ajouté avec succès !');

                ->with(
                    'flash',
                    [
                        'message' => 'Produit ajouté avec succès !',
                        'text' => 'ajoutez un autre',
                        'href' => route('products.create')
                    ]
                );



        } catch (\Exception $e) {
            return redirect()->back()
                // ->with('error', 'Erreur lors de l\'ajout du produit : ' . $e->getMessage());
                ->with(
                    'flash',
                    [
                        'message' => 'Erreur lors de l\'ajout du produit',
                        'text' => 'Essayez encore',
                        'href' => route('products.create')
                    ]
                );


        }
    }


    public function indexBackend(Request $request)
    {
        // Requête de base
        $query = Product::with(['category:id,name', 'images'])
            ->withCount('likes'); // 💙 Ajout du compteur de likes;

        // 🔍 Filtre recherche
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // 📦 Filtre catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // **Tri du plus récent au plus ancien**
        $query->orderBy('created_at', 'desc');

        // Pagination
        $products = $query->paginate(5)->withQueryString();

        // 📊 Statistiques globales
        $totalProducts = Product::count();
        $addedThisWeek = Product::where('created_at', '>=', now()->startOfWeek())->count();

        // 📈 Produits par catégorie (sécurisé)
        $productsByCategory = Product::selectRaw('category_id, count(*) as count')
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get();
        $categories = Category::select('id', 'name')->get();



        return Inertia::render('backend/produits/Index', [
            'products' => $products,
            'stats' => [
                'total' => $totalProducts,
                'addedThisWeek' => $addedThisWeek,
                'byCategory' => $productsByCategory,
            ],
            'filters' => $request->only(['search', 'category']),
            'categories' => $categories,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()

                ->with('error', 'produits introuvable.');

            // ->with(
            // 'flash',
            // [
            // 'message' => 'produits introuvable.',
            // 'text' => '',
            //'href' => route('')
            // ]
            // );

        }

        $product->delete();

        // Redirection compatible Inertia
        return Inertia::location(route('products.index'));
    }


    // Formulaire d'édition
    // public function edit(Product $product)
    // {
    //     $categories = Category::all();
    //     return inertia('backend/produits/Edit', [
    //         'product' => $product->load('images'),
    //         'categories' => $categories,
    //     ]);
    // }


    public function edit(Product $product)
    {
        $categories = Category::all();

        // Charge les images et transforme l'url_image en URL absolue
        $product->load('images');
        $product->getRelation('images')->transform(function ($image) {
            $image->url_image = asset($image->url_image); // → devient : http://localhost:8000/imageProducts/xxx.jpg
            return $image;
        });

        return inertia('backend/produits/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }




    // Mise à jour du produit
    // public function update(Request $request, Product $product)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'prix' => 'required|numeric|min:0',
    //         'stock' => 'required|integer|min:0',
    //         'category_id' => 'required|exists:categories,id',
    //         'status' => 'required|in:disponible,indisponible',
    //         'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    //     ]);

    //     $product->update($validated);

    //     // Gestion des images
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $file) {
    //             $path = $file->store('products', 'public');
    //             $product->images()->create(['url_image' => $path]);
    //         }
    //     }

    //     return redirect()->route('products.index', $product->id)
    //         // ->with('success', 'Produit mis à jour avec succès');
    //         ->with(
    //             'flash',
    //             [
    //                 'message' => 'Produit mis à jour avec succès',
    //                 // 'text' => '',
    //                 //'href' => route('')
    //             ]
    //         );
    // }



    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:disponible,indisponible',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            // ✅ CORRIGÉ ICI 👇
            'keepOldImages' => 'nullable|array',
            'keepOldImages.*' => 'exists:products_image,id', // ✅ Bon nom de table
        ]);

        $product->update($validated);

        // Supprimer les images non conservées
        $keepIds = $request->input('keepOldImages', []);
        $product->images()->whereNotIn('id', $keepIds)->each(function ($image) {
            $path = public_path($image->url_image);
            if (file_exists($path)) {
                unlink($path);
            }
            $image->delete();
        });


        // Ajouter nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('imageProducts'), $filename);

                $product->images()->create([
                    'url_image' => 'imageProducts/' . $filename,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('flash', ['message' => 'Produit mis à jour avec succès']);
    }






    public function show(Product $product)
    {
        // Charger les images et likes
        $product->load('images');
        return Inertia::render('backend/products/ProductDetail', [
            'product' => $product,
            'auth' => auth()->user()
        ]);
    }




}
