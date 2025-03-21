<?php

namespace App\Http\Controllers;

use App\Repositores\CartRepository\CartRepositories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(CartRepositories $cart)
    {
        $products = Product::select('id', 'name', 'price', 'image', 'description')
            ->where('quantity', '>=', 1)->get();
        return view('index', compact('products', 'cart'));
    }
}
