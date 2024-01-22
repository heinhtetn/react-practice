<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function all()
    {
        $order = ProductOrder::with('user', 'product')->latest()->paginate(10);

        return view('admin.order.all', compact('order'));
    }
}
