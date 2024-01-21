<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAddTransaction;
use App\Models\ProductRemoveTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $supplier = Supplier::all();
        $brand = Brand::all();
        $color = Color::all();
        $category = Category::all();

        return view('admin.product.create', compact('supplier', 'color', 'brand', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'total_quantity' => 'required|integer',
            'buy_price' => 'required|integer',
            'sale_price' => 'required|integer',
            'discounted_price' => 'required|integer',
            'supplier_slug' => 'required|string',
            'category_slug' => 'required|string',
            'brand_slug' => 'required|string',
            'color_slug.*' => 'required|string',
            'image' => 'required|mimes:jpg,png,jpeg,webp|max:2048'
        ]);
        
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/images'), $image_name);

        $category = Category::where('slug', $request->category_slug)->first();
        if(!$category)
        {
            return redirect()->back()->with('error', 'Category not found');
        }

        $brand = Brand::where('slug', $request->brand_slug)->first();
        if(!$brand)
        {
            return redirect()->back()->with('error', 'Brand not found');
        }

        $supplier = Supplier::where('id', $request->supplier_slug)->first();
        if(!$supplier)
        {
            return redirect()->back()->with('error', 'Supplier not found');
        }

        $colors = [];
        foreach($request->color_slug as $c)
        {
            $color = Color::where('slug', $c)->first();
            if(!$color)
            {
                return redirect()->back()->with('error', 'Color not found');
            }
            $colors[] = $color->id;

        }

        $product = Product::create([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'brand_id' => $brand->id,
            'slug' => uniqid() . Str::slug($request->name),
            'name' => $request->name,
            'image' => $image_name,
            'discount_price' => $request->discounted_price,
            'sale_price' => $request->sale_price,
            'buy_price' => $request->buy_price,
            'total_quantity' => $request->total_quantity,
            'view_count' => 0,
            'like_count' => 0,
            'description' => $request->description

        ]);

        ProductAddTransaction::create([
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
            'total_quantity' => $request->total_quantity,

        ]);

        $p = Product::find($product->id);
        $p->colors()->sync($colors);

        return redirect()->back()->with('success', 'Product created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $supplier = Supplier::all();
        $brand = Brand::all();
        $color = Color::all();
        $category = Category::all();
        $p = Product::where('slug', $id)
        ->with('supplier', 'brand', 'colors', 'category')
        ->first();

        if(!$p)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        return view('admin.product.edit', compact('p', 'supplier', 'brand', 'color', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $find_product = Product::where('slug', $id);

        $product_id = $find_product->first()->id;

        if(!$find_product->first())
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        if($request->file('image'))
        {
            $image = $request->file('image');
            $image_name = uniqid() . $image->getClientOriginalName();
            $image->move(public_path('/images'), $image_name);
        }
        else
        {
            $image_name = $find_product->first()->image;
        }

        $category = Category::where('slug', $request->category_slug)->first();

        if(!$category)
        {
            return redirect()->back()->with('error', 'Category not found');
        }

        $brand = Brand::where('slug', $request->brand_slug)->first();

        if(!$brand)
        {
            return redirect()->back()->with('error', 'Brand not found');
        }

        $supplier = Supplier::where('id', $request->supplier_slug)->first();
        if(!$supplier)
        {
            return redirect()->back()->with('error', 'Supplier not found');
        }

        $colors = [];
        foreach($request->color_slug as $c)
        {
            $color = Color::where('slug', $c)->first();
            if(!$color)
            {
                return redirect()->back()->with('error', 'Color not found');
            }
            $colors[] = $color->id;

        }

        $slug = uniqid() . Str::slug($request->name);

        $find_product->update([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'brand_id' => $brand->id,
            'slug' => $slug,
            'name' => $request->name,
            'image' => $image_name,
            'discount_price' => $request->discounted_price,
            'sale_price' => $request->sale_price,
            'buy_price' => $request->buy_price,
            'total_quantity' => $request->total_quantity,
            'view_count' => 0,
            'like_count' => 0,
            'description' => $request->description

        ]);

        $product = Product::find($product_id);
        $product->colors()->sync($colors);

        return redirect()->route('product.edit', $slug)->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = Product::where('id', $id)->first();
        if(!$p)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        File::delete(public_path('/images/' . $p->image));

        Product::find($p->id)->colors()->sync([]);

        $p->delete();

        return redirect()->back()->with('delete', 'Product Deleted');
    }

    public function imageUpload()
    {
        $file = request()->file('image');
        $file_name = uniqid() . $file->getClientOriginalName();
        $file->move(public_path('/images'), $file_name);

        return asset('/images/'. $file_name);
    }

    public function createProductAdd($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        $supplier = Supplier::all();

        return view('admin.product.create-product-add', compact('product', 'supplier'));
    }  
    
    public function createProductRemove($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        $supplier = Supplier::all();

        return view('admin.product.create-product-remove', compact('product', 'supplier'));
    } 

    public function storeProductAdd(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        ProductAddTransaction::create([
            'product_id' => $product->id,
            'supplier_id' => $request->supplier_id,
            'total_quantity' => $request->total_quantity,
            'description' => $request->description
        ]);

        $product->update([
            'total_quantity' => DB::raw('total_quantity+' . $request->total_quantity)
        ]);

        return redirect()->back()->with('success', $request->total_quantity . ' added');
    }

    public function storeProductRemove(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product)
        {
            return redirect()->back()->with('error', 'Product not found');
        }

        ProductRemoveTransaction::create([
            'product_id' => $product->id,
            'total_quantity' => $request->total_quantity,
            'description' => $request->description
        ]);

        $product->update([
            'total_quantity' => DB::raw('total_quantity-' . $request->total_quantity)
        ]);

        return redirect()->back()->with('success', $request->total_quantity . ' removed');
    }

    public function addTransaction()
    {
        $transactions = ProductAddTransaction::with('product')->paginate(10);

        return view('admin.product.add-transaction', compact('transactions'));
    }

    public function removeTransaction()
    {
        $transactions = ProductRemoveTransaction::with('product')->paginate(10);

        return view('admin.product.remove-transaction', compact('transactions'));
    }
}
