<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description'];

    public function transactions()
    {
        return $this->hasMany(ProductAddTransaction::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
