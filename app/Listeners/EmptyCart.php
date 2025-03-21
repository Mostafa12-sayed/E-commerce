<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Repositores\CartRepository\CartRepositories;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        Cart::empty();
    }
}
