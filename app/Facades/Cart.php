<?php


namespace App\Facades;

use App\Repositores\CartRepository\CartRepositories;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepositories::class;
    }
}
