<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inventory extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'warehouse_id', 'stock'];

    public function products()
    {
         return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
