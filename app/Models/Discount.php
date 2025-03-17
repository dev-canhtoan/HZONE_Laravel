<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';
    public $timestamps = false;
    public function products() {
        return $this->hasMany(Product::class, 'dis_id', 'id');
    }
}