<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;

    protected $fillable =[
        'name',
        'code',
        'quantity',
        'condition',
        'number',
        'description',
        'status',
    ];

    protected $table = 'coupons';
}
