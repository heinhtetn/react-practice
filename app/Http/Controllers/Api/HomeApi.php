<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeApi extends Controller
{
    //
    public function home()
    {
        $category = Category::withCount('products')->get();

        try {
            $featuredProduct = Product::all()->random(2);
        } catch (\Throwable $th) {
            $featuredProduct = [];
        }

        $productByCategory = Category::has('products')->take(2)->get();

        foreach($productByCategory as $k => $v)
        {
            $productByCategory[$k]->product = Product::where('category_id', $v->id)->take(6)->get();   
        }

        return response()->json([
            'message' => 'true',
            'data' => [
                'category' => $category,
                'featuredProduct' => $featuredProduct,
                'productByCategory' => $productByCategory
            ]
            ],200, [], JSON_PRETTY_PRINT);
    }
}
