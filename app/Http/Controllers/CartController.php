<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositores\CartRepository\CartRepositories;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function index(CartRepositories $cart)
    {
        return view('cart', [
            'cart' => $cart
        ]);
    }

    public function store(Request $request, CartRepositories $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $cart->add($product, $request->post('quantity'));

        flash("Insert Successfully", 'success');
        return back();
    }
    public function update(Request $request, CartRepositories $cart, $id)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $update = $cart->update($id, $product, $request->post('quantity'));
        return response()->json($update, 200);
    }

    public function destroy($id, CartRepositories $cart)
    {
        $cart->delete($id);
        flash("Deleted Successfully", 'success');
        return back();
    }

    public function confirmOrder(CartRepositories $cart)
    {
        dd($cart->get());
    }
}
