<?php

namespace App\Http\Controllers;

use App\Events\EmptyCartEvent;
use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Listeners\EmptyCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositores\CartRepository\CartModelRepository;
use App\Repositores\CartRepository\CartRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function create(CartRepositories $cart)
    {
        if ($cart->get()->count() == 0) {
            flash("Your cart is empty", 'info');
            return to_route('cart.index');
        }
        return view('payment.checkout', [
            'cart' => $cart,
        ]);
    }

    public function store(CheckoutRequest $request, CartRepositories $cart)
    {
        $address = $request->all();
        $items = $cart->get();

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method' => $request->payment_method ?? 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'total' => $cart->total(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }

            $address['order_id'] = $order->id;
            $order->addersses()->create($address);
            DB::commit();

            if ($request->payment_method === 'card') {
                return redirect()->route('checkout.payment', ['orderId' => $order->id]);
            } else {
                $order->status = 'processing';
                $order->save();
                event(new OrderCreated($order));
                flash("Order placed successfully", 'success');
                return redirect()->route('home');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            flash($exception->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
