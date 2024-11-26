<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable =[
        'used_id',
        'order_date',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
    ];

    protected $table = 'orders';

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
