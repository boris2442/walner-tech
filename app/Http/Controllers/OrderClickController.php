<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderClick;

class OrderClickController extends Controller
{
   public function store(Request $request)
    {
        OrderClick::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['success' => true]);
    }
}
