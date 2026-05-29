<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_name','customer_phone','customer_phone2','wilaya','commune','address','delivery_type','status','notes','total'];
    public function items() { return $this->hasMany(OrderItem::class); }
}
