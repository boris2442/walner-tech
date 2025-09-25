<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductImage extends Model
{
    use HasFactory;

    // Nom de la table si différent de la convention Laravel
    protected $table = 'products_image';

    protected $fillable = [
        'product_id',
        'url_image',
    ];

    // Relation avec le produit parent
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
