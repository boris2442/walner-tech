<?php

namespace App\Http\Controllers;

use App\Models\LikeProduit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeProduitController extends Controller
{
    /**
     * Gère l'ajout ou le retrait d'un like sur un produit.
     */
    public function toggle($productId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Vous devez être connecté pour liker.'], 401);
        }

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Vérifie si l'utilisateur a déjà liké ce produit
        $like = LikeProduit::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($like) {
            // Si déjà liké, on supprime le like
            $like->delete();
            $liked = false;
        } else {
            // Sinon on crée un nouveau like
            LikeProduit::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $liked = true;
        }

        // Nombre total de likes du produit
        $likesCount = LikeProduit::where('product_id', $product->id)->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount,
        ]);
    }
}
