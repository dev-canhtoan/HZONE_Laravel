<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'dis_id');
    }
    public function spec()
    {
        return $this->hasOne(Spec::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}