<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;


interface ProductRepositoryInterface
{
   public function all();

   
   public function product_filter($cateId, $start, $colors, $sizes, $sort, $price, $limit);
}