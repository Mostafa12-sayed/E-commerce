<?php

namespace App\Listeners;


use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DedectProductCheckoutListener
{

    public function __construct()
    {
        //
    }

    public function handle(OrderCreated $event)
    {
        //        dd($event->order->products);
        foreach ($event->order->products as $product) {

            $product->decrement('quantity', $product->pivot->quantity);

            //            Product::where('id',$item->product_id)
            //                ->update(['quantity' => DB::Raw("quantity- {$item->quantity}")]);



        }
    }
}
