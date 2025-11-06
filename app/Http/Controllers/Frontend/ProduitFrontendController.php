<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
;
use App\Models\Category;
class ProduitFrontendController extends Controller
{
    //     public function index(Request $request)
//     {
//         // On récupère tous les produits avec leurs images, catégorie et compteur de likes
//         $query = Product::with(['category', 'images'])
//             ->withCount('likes');

    //         // Filtre par recherche si rempli
//         if ($request->has('search') && $request->search != '') {
//             $query->where('title', 'like', "%{$request->search}%");
//         }
//         // **Tri du plus récent au plus ancien**
//         $query->orderBy('created_at', 'desc');
//         // Filtre par catégorie si demandé
//         if ($request->has('category') && $request->category != '') {
//             $query->where('category_id', $request->category);
//         }


    //         // On récupère tous les produits (sans pagination)
//         $products = $query->get()->map(function ($product) {
//             $product->liked = auth()->check()
//                 ? $product->likes()->where('user_id', auth()->id())->exists()
//                 : false;
//             return $product;
//         });

    //         // Récupération des catégories
//         $categories = Category::all();

    //         return Inertia::render('backend/products/ProductIndex', [
//             'products' => $products,          // renvoie tous les produits avec likes_count + liked
//             'categories' => $categories,      // toutes les catégories
//             'filters' => $request->only(['search', 'category']),
//             'auth' => [
//                 'user' => auth()->user()
//             ],
//             'seo' => [
//                 'title' => 'Walner Tech e-commerce - Marketplace d’ordinateurs, smartphones et accessoires au Cameroun

    // ',
//                 'description' => 'Walner Tech, votre marketplace à Bafoussam et Yaoundé : achetez ordinateurs portables, PC, smartphones et accessoires informatiques de qualité au meilleur prix.
// ',
//                 'image' => asset('walner.jpg'), // image OG principale pour le partage social
//                 'url' => url('/'),
//                 'robots' => 'index, follow',
//             ],

    //         ]);
//     }



    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Product::with(['category', 'images'])
            ->withCount('likes')
            ->when($userId, function ($q) use ($userId) {
                $q->withExists([
                    'likes as liked' => function ($likeQuery) use ($userId) {
                        $likeQuery->where('user_id', $userId);
                    }
                ]);
            });

        // 🔍 Filtre recherche
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // 🏷️ Filtre catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // ⏰ Tri du plus récent
        $query->orderBy('created_at', 'desc');

        // ⚡ Récupération produits optimisée
        $products = $query->get();

        // 🧩 Récupération des catégories
        $categories = Category::all();

        return Inertia::render('backend/products/ProductIndex', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
            'auth' => ['user' => auth()->user()],
            'seo' => [
                'title' => 'Walner Tech e-commerce - Marketplace d’ordinateurs, smartphones et accessoires au Cameroun',
                'description' => 'Walner Tech, votre marketplace à Bafoussam et Yaoundé : achetez ordinateurs portables, PC, smartphones et accessoires informatiques de qualité au meilleur prix.',
                'image' => asset('walner.jpg'),
                'url' => url('/'),
                'robots' => 'index, follow',
            ],
        ]);
    }




    public function showBySlug($slug)
    {
        $product = Product::with('images', 'category', 'descriptionProduct')
            ->where('slug', $slug)
            ->firstOrFail();

        // Transformer le modèle en tableau et la relation descriptionProduct aussi
        $productArray = $product->toArray();

        // Si descriptionProduct existe, garder le contenu, sinon null
        $productArray['descriptionProduct'] = $product->descriptionProduct
            ? $product->descriptionProduct->toArray()
            : null;

        // Produits similaires
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(10)
            ->get()
            ->toArray(); // transformer en tableau

        return Inertia::render('backend/products/ProductDetail', [
            'product' => $productArray,
            'similarProducts' => $similarProducts,
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);
    }



}
