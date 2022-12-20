<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerModel extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email'
    ];

    public function order()
    {
        return $this->hasMany('App\Models\orderModel');
    }
    public function set_order($order)
    {
        $this->order_id = $order->id;
        return $this->save();
    }
}
