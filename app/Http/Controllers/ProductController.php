<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product; //LOAD MODEL PRODUCT

class ProductController extends Controller
{
    public function index()
    {
        //BUAT QUERY MENGGUNAKAN MODEL PRODUCT, DENGAN MENGURUTKAN DATA BERDASARKAN CREATED_AT
        //KEMUDIAN LOAD TABLE YANG BERELASI MENGGUNAKAN EAGER LOADING WITH()
        //ADAPUN CATEGORY ADALAH NAMA FUNGSI YANG NNTINYA AKAN DITAMBAHKAN PADA PRODUCT MODEL
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');

        //JIKA TERDAPAT PARAMETER PENCARIAN DI URL ATAU Q PADA URL TIDAK SAMA DENGAN KOSONG
        if (request()->q != '') {
            //MAKA LAKUKAN FILTERING DATA BERDASARKAN NAME DAN VALUENYA SESUAI DENGAN PENCARIAN YANG DILAKUKAN USER
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }
        //TERAKHIR LOAD 10 DATA PER HALAMANNYA
        $product = $product->paginate(10);
        //LOAD VIEW INDEX.BLADE.PHP YANG BERADA DIDALAM FOLDER PRODUCTS
        //DAN PASSING VARIABLE $PRODUCT KE VIEW AGAR DAPAT DIGUNAKAN
        return view('products.index', compact('product'));
    }
}
