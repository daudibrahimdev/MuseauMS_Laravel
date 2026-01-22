<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 
    'user_id', 
    'total_price', 
    'payment_status', 
    'snap_token',
    'payment_proof',
    ];

    public function items() { 
        return $this->hasMany(OrderItem::class); 
        } 
    public function user() { 
        return $this->belongsTo(User::class); 
        } 
    public function shipment() { 
        return $this->hasOne(Shipment::class); 
        } 
}
