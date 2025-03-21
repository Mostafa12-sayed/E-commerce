<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = ['cookie_id', 'user_id', 'product_id', 'quantity', 'options'];


    public static function booted()
    {
        static::observe(CartObserver::class);

        static::addGlobalScope('cookie', function (Builder $builder) {
            // $builder->where('cookie_id', Cart::getcookieId());
            if (method_exists($builder, 'where')) {
                $builder->where('cookie_id', self::getCookieId());
            }
        });
    }

    public static function getcookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 24 * 30 * 60);
            return $cookie_id;
        }
        return $cookie_id;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Annonymous'
        ]);
    }
}
