<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'supplier_id', 'brand_id', 'slug', 'name', 'image', 'discount_price', 'sale_price','buy_price', 'total_quantity', 'view_count', 'like_count', 'description'];

    protected $appends = ['image_url'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function transactions()
    {
        return $this->hasMany(ProductAddTransaction::class);
    }

    public function carts()
    {
        return $this->hasMany(ProductCart::class);
    }

    public function orders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('/images/'.$this->image);
    }
}
