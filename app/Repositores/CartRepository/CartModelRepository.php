<?php

namespace App\Repositores\CartRepository;

use ILLUMINATE\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Repositores\CartRepository\CartRepositories;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepositories


{
    protected $items;
    public function __construct()
    {
        $this->items = collect([]);
    }
    public function get()
    {
        if (!$this->items->count()) {
            $this->items = Cart::with(['product'])->get();
        }
        return $this->items;
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', $product->id)->first();
        if (!$item) {
            $cart = Cart::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'user_id' => Auth::id()
            ]);
            $this->get()->push($cart);
            return $cart;
        }
        return  $item->increment('quantity', $quantity);
    }

    public function update($id, $product, $quantity)
    {
        $cart = Cart::where('id', '=', $id);

        $update = $cart->update(['quantity' => $quantity]);
        // dd($cart);
        if ($update) {
            // return [
            //     'message' => 'quantity updated Successfully',
            //     'alert-type' => 'success'
            // ];
            return $cart->get()->load('product');
        }
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)->delete();
    }


    public function empty()
    {
        // dd(Cart::query());
        Cart::query()->delete();
    }

    public function total(): float
    {
        // dd($this->items);

        //        return (float) Cart::where('cookie_id' ,'=',Cart::getcookieId())
        //        ->join('products','products.id','=','carts.product_id')
        //
        //        ->selectRaw('SUM(products.price * carts.quantity) as total')
        //        ->value('total');
        //        dd($this->items);
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function getCount()
    {
        return $this->items->count();
    }
}
