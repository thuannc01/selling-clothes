<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
   public function all()
   {
       return Product::all();
   }

   public function getProductByCategoryId($cateId)
   {
	   $query = "Select * from product where categoryId = ".$cateId;
	   $list_product = DB::select($query);
	   return $list_product;
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
	public function product_filter($cateId, $start, $colors = array(), $sizes = array(), $sort, $price = array(), $limit) {
		
		// 
		if($sort == "desc"){$sort_param = "- price";}
		else {$sort_param = "price";}

		if ($price[1] != -1) {
			$max_query = " And price <= " . (string) $price[1];} else {
			$max_query = "";}
		
		if ($price[0] != -1) {
			$min_query = " And price >= " . (string) $price[0];} else {
			$min_query = "";}

		if (strlen($colors) > 0){
			$color_query = 'AND v.colorId in ' . ', ' .'';
		} else {$color_query = "";}

		if (strlen($sizes) > 0){
			$size_query = "LEFT JOIN size sz ON v.id = sz.variantId AND sz.size in";
		} else {$size_query = "";}

		$query = 'SELECT p.id, p.name, price, p.img as img_url, sum(s.quantity) as qty, vc.color, IFNULL(discount, 0) AS discount, IFNULL((100 - discount) * (price / 100), 0) AS salePrice'
		. 'FROM'
		. 'product p JOIN variation v ON p.id = v.productId '. $color_query + $size_query
		. 'JOIN size s on v.id = s.variantId'
		. 'LEFT JOIN'
		. '(select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc'
		. 'ON vc.productId = p.id'
		. 'LEFT JOIN'
		. 'productsales ps ON p.id = ps.productid'
		. 'LEFT JOIN salespromotion sp ON ps.salesid = sp.id'
		. 'AND CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd'
		. 'JOIN category cate ON p.categoryId = cate.id'
		. 'AND (cate.parentsId = {} OR p.categoryId = {})'
		. 'WHERE '. $cateId . $min_query . $max_query
		. 'GROUP BY p.id , name , price , discount , salePrice'
		. 'ORDER BY {},-p.id ' .$sort_param;

		$list_product = DB::select($query);
		return $list_product;
	}

	public function get_weekly_best_product($limit, $cateId){
		$query = "select \n" 
        ." p.id, \n"
        ." p.name, \n"
        ." price, \n"
        ." sum(s.quantity) as qty, \n"
        ." p.img AS img_url, \n"
        ." vc.color, \n"
        ." IFNULL(discount, 0) AS discount, \n"
        ." IFNULL((100 - discount) * (price / 100), 0) AS salePrice \n"
		." FROM \n"
			." product p \n"
				." JOIN \n"
			." variation v ON p.id = v.productId \n"
				." JOIN \n" 
			." size s on v.id = s.variantId \n"
				." LEFT JOIN \n"
			." productsales ps ON p.id = ps.productid \n"
				." LEFT JOIN \n"
			." (select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc \n"
			." ON vc.productId = p.id \n"
				." LEFT JOIN \n"
			." salespromotion sp ON ps.salesid = sp.id \n"
				." and CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd \n"
				." JOIN \n"
			." category cate ON (p.categoryId = cate.id \n"
				." and  cate.parentsId = ". $cateId .") \n"
				." OR p.categoryId = " . $cateId ." \n"
				." JOIN \n"
			." (SELECT \n"
				." productId, SUM(quantity) qty \n"
			." FROM \n"
				." detailreceipt dr \n"
			." JOIN receipt rc ON rc.id = dr.receiptId \n"
				." and rc.timeOrder >= DATE_SUB(NOW(), INTERVAL 7 DAY) \n"
			." GROUP BY productId \n"
			." ORDER BY - SUM(quantity) \n"
			." LIMIT ". $limit .") h ON h.productId = p.id \n"
		." GROUP BY p.id , name , price , discount , salePrice \n"
		." ORDER BY - h.qty";
		
		return DB::select(DB::raw($query));
	}
	
	public function get_new_product($limit, $cateId)
	{
		$query = "select p.id, p.name, price, sum(s.quantity) as qty, p.img as img_url, vc.color, IFNULL(discount, 0) AS discount, IFNULL((100 - discount) * (price / 100), 0) AS salePrice "
		." FROM product p JOIN variation v ON p.id = v.productId JOIN size s on v.id = s.variantId LEFT JOIN (select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc ON vc.productId = p.id LEFT JOIN productsales ps ON p.id = ps.productid LEFT JOIN salespromotion sp ON ps.salesid = sp.id AND CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd JOIN category cate ON p.categoryId = cate.id AND (cate.parentsId = ".$cateId." OR p.categoryId = ". $cateId.")"
		." GROUP BY p.id , name , price , discount , salePrice"
		." ORDER BY -p.id LIMIT " .$limit;

		return DB::select(DB::raw($query));	
	}
	/**
	 * @param mixed $searchStr
	 * @param mixed $limit
	 * @return mixed
	 */
	public function search_products($searchStr, $limit) {
		$query = "select p.id, p.name, price, sum(s.quantity) as qty, p.img as img_url, vc.color, IFNULL(discount, 0) AS discount, IFNULL((100 - discount) * (price / 100), 0) AS salePrice"
		." FROM product p JOIN variation v ON p.id = v.productId JOIN size s on v.id = s.variantId LEFT JOIN"
		." (select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc ON vc.productId = p.id LEFT JOIN"
		." productsales ps ON p.id = ps.productid LEFT JOIN"
		." salespromotion sp ON ps.salesid = sp.id"
		." and CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd"
		." WHERE p.name like '%". $searchStr ."%'"
		." GROUP BY p.id , name , price , discount , salePrice"
		." ORDER BY -p.id ";

		if($searchStr == ""){
			$query += " LIMIT "  + (string)$limit;
		}

		return DB::select(DB::raw($query));	
	}
}
