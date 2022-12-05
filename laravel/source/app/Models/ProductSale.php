<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;
    protected $table = 'productsales';
    protected $primaryKey = ['productid', 'saleid'];
    public $incrementing = false;
    protected $fillable = ['deleted'];
}
