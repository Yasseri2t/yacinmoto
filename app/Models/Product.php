<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'image', 'brand', 'compatible_models', 'in_stock', 'is_piece_of_day', 'section'];
    protected $casts = ['in_stock' => 'boolean', 'is_piece_of_day' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }
}
