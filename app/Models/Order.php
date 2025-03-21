<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'payment_method', 'user_id', 'total', 'status', 'number', 'payment_status'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->withPivot(['quantity', 'price', 'options', 'product_name']);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }


    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public function addersses()
    {
        return $this->belongsTo(OrderAddress::class, 'order_id');
    }


    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', Carbon::now()->year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
