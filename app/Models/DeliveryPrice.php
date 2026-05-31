<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryPrice extends Model
{
    protected $fillable = ['wilaya_number', 'wilaya_name', 'home_price', 'office_price'];
}
