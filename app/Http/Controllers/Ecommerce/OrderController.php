<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', auth()->guard('customer')->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('ecommerce.orders.index', compact('orders'));
    }

    public function view($invoice)
    {
        $order = Order::with(['district.city.province', 'details', 'details.product', 'payment'])
            ->where('invoice', $invoice)->first();
        return view('ecommerce.orders.view', compact('order'));
    }
}
