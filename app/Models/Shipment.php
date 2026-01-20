<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id', 
        'tracking_code', 
        'courier_name', 
        'status', 
        'shipping_address', 
        'estimated_arrival'
        ];

    public function order() 
    { 
        return $this->belongsTo(Order::class); 
    }
}
