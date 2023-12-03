<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isInWishlist($product_id)
    {
        $wishlistItems = $this('product_id', $product_id);
        foreach ($wishlistItems as $item) {
            if ($item->id === $product_id) {
                return true; 
            }
        }

        return false;
    }

  
}
