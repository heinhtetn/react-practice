<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailApi extends Controller
{
    //
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
        ->with('reviews.user', 'brand', 'category', 'colors')
        ->first();

        if(!$product)
        {
            return response()->json([
                'success' => 'false',
                'data' => "product_not_found"
            ], 200, [], JSON_PRETTY_PRINT);
        }

        return response()->json([
            'success' => 'true',
            'data' => $product
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
