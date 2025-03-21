<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $table = 'order_adrresses';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone_number',
        'street_addresses',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
