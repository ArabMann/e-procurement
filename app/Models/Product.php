<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        "name", "description", "slug", "category_id", "vendor_id"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
