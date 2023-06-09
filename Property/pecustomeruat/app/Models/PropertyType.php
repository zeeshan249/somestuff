<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
    protected $table="property_type";
    protected $guarded=[];
    public function submenu()
    {
        return $this->hasMany(ProductCategory::class,'nav_id','property_type_id');
    }
}
