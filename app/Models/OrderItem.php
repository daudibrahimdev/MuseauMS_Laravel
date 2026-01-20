<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
    protected $fillable = [
    'order_id', 
    'artwork_id', 
    'price_at_purchase'
    ];

    public function artwork() 
    { 
        return $this->belongsTo(Artwork::class); 
    } 
    public function order() 
    { 
        return $this->belongsTo(Order::class); 
    }
}
