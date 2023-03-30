<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table="product_category";
    protected $guarded=[];

    public function menu()
    {
        return $this->belongsTo(PropertyType::class,'product_category_id','nav_id');
    }
}
