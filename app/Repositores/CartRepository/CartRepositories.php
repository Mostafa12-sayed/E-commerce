<?php

namespace App\Repositores\CartRepository;

use App\Models\Product;

interface CartRepositories
{
    public function get();
    public function add(Product $product);
    public function delete($id);
    public function update($id, $product, $quantity);
    public function empty();
    public function total();
    public function getCount();
}
