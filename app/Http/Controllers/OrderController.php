<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        //QUERY UNTUK MENGAMBIL SEMUA PESANAN DAN LOAD DATA YANG BERELASI MENGGUNAKAN EAGER LOADING
        //DAN URUTANKAN BERDASARKAN CREATED_AT
        $orders = Order::with(['customer.district.city.province'])
            ->orderBy('created_at', 'DESC');

        //JIKA Q UNTUK PENCARIAN TIDAK KOSONG
        if (request()->q != '') {
            //MAKA DIBUAT QUERY UNTUK MENCARI DATA BERDASARKAN NAMA, INVOICE DAN ALAMAT
            $orders = $orders->where(function ($q) {
                $q->where('customer_name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('invoice', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('customer_address', 'LIKE', '%' . request()->q . '%');
            });
        }

        //JIKA STATUS TIDAK KOSONG 
        if (request()->status != '') {
            //MAKA DATA DIFILTER BERDASARKAN STATUS
            $orders = $orders->where('status', request()->status);
        }
        $orders = $orders->paginate(10); //LOAD DATA PER 10 DATA
        return view('orders.index', compact('orders')); //LOAD VIEW INDEX DAN PASSING DATA TERSEBUT
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->details()->delete();
        $order->payment()->delete();
        $order->delete();
        return redirect(route('orders.index'));
    }
}
