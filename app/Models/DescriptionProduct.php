<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DescriptionProduct extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'description_product';

    // Champs pouvant être remplis en mass assignment
    protected $fillable = [
        'product_id',
        'content',
    ];

    // Relation vers Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
