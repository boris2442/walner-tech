<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderClick;

class OrderClickController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.prix' => 'required|numeric|min:0', // prix unitaire
        ]);

        $userId = auth()->id();

        foreach ($request->items as $item) {
            OrderClick::create([
                'user_id' => $userId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'prix' => $item['prix'], // ici juste le prix unitaire
            ]);
        }

        return redirect()->back()->with('success', 'Commande enregistrée avec succès !');
    }

}
