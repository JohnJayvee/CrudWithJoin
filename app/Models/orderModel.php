<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderModel extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
        'customer_id',
        'delivery_address',
        'phone_number',
        'package_weight',
        'dimension'
    ];
    public function customer()
    {
        return $this->belongsTo('App\Models\customerModel');
    }

}