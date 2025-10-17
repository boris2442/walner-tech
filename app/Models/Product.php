<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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

    public function orderClicks()
    {
        return $this->hasMany(OrderClick::class);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->uuid = (string) Str::uuid();
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // On génère d'abord un slug temporaire
            $product->slug = Str::slug($product->title);
        });

        static::created(function ($product) {
            // Une fois l'ID connu, on le met à jour avec l’ID à la fin
            $product->slug = Str::slug($product->title) . '-' . $product->id;
            $product->saveQuietly(); // évite une boucle infinie
        });
    }

}
