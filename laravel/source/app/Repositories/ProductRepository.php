<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
   public function all()
   {
       return Product::all();
   }

	/**
	 * @param mixed $cateId
	 * @param mixed $start
	 * @param mixed $colors
	 * @param mixed $sizes
	 * @param mixed $sort
	 * @param mixed $price
	 * @param mixed $limit
	 * @return mixed
	 */
	public function product_filter($cateId, $start, $colors, $sizes, $sort, $price, $limit) {
	}
}