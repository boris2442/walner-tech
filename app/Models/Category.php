<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable = ['name', 'description'];


    // Une catégorie peut avoir plusieurs produits
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
