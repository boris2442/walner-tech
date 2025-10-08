<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Product;

return new class extends Migration {
    public function up(): void
    {
        // 1️⃣ Ajouter la colonne uuid nullable
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        // 2️⃣ Remplir les produits existants avec un UUID
        Product::all()->each(function ($product) {
            $product->uuid = (string) Str::uuid();
            $product->save();
        });

        // 3️⃣ Rendre la colonne uuid unique et non nullable
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
