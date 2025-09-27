<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    // Champs autorisés à la création
    protected $fillable = [
        'title',
        'description',
        'prix',
        'stock',
        'category_id',
        'status',
    ];

    // Relation avec les images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Relation avec la catégorie
    // Un produit appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   // Product.php
public function likes()
{
    return $this->hasMany(\App\Models\LikeProduit::class);
}


// public function isLikedBy($user)
// {
//     return $this->likes()->where('user_id', $user->id)->exists();
// }



}
