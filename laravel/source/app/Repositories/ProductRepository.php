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
	}

	public function get_product($productId){
		$query = "select p.id, p.name, p.img as img_url, price, IFNULL(discount, 0) AS discount, IFNULL((100 - discount) * (price / 100), 0) AS salePrice, description, categoryId"
		." FROM product p"
		." JOIN variation v ON v.productId = p.id"
		." LEFT JOIN productsales ps ON p.id = ps.productid"
		." LEFT JOIN salespromotion sp ON ps.salesid = sp.id"
		." and CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd"
		." WHERE p.id = " .$productId;

		$result = DB::select(DB::raw($query));
		if(isset($result)){
			$results = (array) $result[0];
		}

		$query = "select v.id, v.thumbnail, c.name, SUM(s.quantity) AS qty"
		." FROM variation v JOIN color c ON c.id = v.colorId JOIN size s ON s.variantId = v.id"
		." WHERE v.productId = ". $productId ." GROUP BY v.id";

		$results['variants'] = DB::select(DB::raw($query));

		foreach ($results['variants'] as $value){
			$query = "select size, quantity from size where variantId = " . $value->id;
			$value->sizes = DB::select(DB::raw($query));

			$query = "select id, url from image where variantId = ". $value->id;
			$value->images = DB::select(DB::raw($query));
		}

		return $results;
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
		." ORDER BY -p.id";

		if($searchStr == ""){
			$query += " LIMIT "  + (string)$limit;
		}

		return DB::select(DB::raw($query));	
	}

	public function get_max_price(){
		$query = "select max(price) as maxPrice from product";

		$result = array();
		$result = DB::select(DB::raw($query));

		return $result[0]->maxPrice;	
	}

	public function get_productsCollection($collectionId, $start){
		if ($start != -1){
			$strLimit = "LIMIT " . $start . ", 8";
		} else {
			$strLimit = "";
		}

		$query = "select  p.id, p.name, price, sum(s.quantity) as qty, p.img as img_url, vc.color, IFNULL(discount, 0) AS discount, IFNULL((100 - discount) * (price / 100), 0) AS salePrice"
		." FROM productcollection pc JOIN product p on pc.productId = p.id"
		." JOIN variation v ON p.id = v.productId"
		." JOIN size s on v.id = s.variantId"
		." LEFT JOIN"
		." (select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc"
		." ON vc.productId = p.id"
		." LEFT JOIN productsales ps ON p.id = ps.productid"
		." LEFT JOIN salespromotion sp ON ps.salesid = sp.id"
		." and CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd"
		." WHERE pc.collectionId = ".$collectionId
		." GROUP BY p.id , name , price , discount , salePrice"
		." ORDER BY -p.id ".$strLimit;

		return (array)DB::select(DB::raw($query));	
	}

	public function productsSale($salesId, $size, $cateId, $start){
		if ($start != -1){
			$strLimit = " LIMIT " . $start . ", 8";
		} else {
			$strLimit = "";
		}

		if ($size != -1){
			$strSize = " and size = " . $size;
		} else {
			$strSize = "";
		} 

		if ($cateId != -1){
			$strCate = "JOIN category cate ON p.categoryId = cate.id
			AND (cate.parentsId = ". $cateId ." OR p.categoryId = ". $cateId .")";
		} else {
			$strCate = "";
		}

		$query = "select p.id, p.name, price, sum(s.quantity) as qty, p.img as img_url, vc.color,"
		." IFNULL(discount, 0) AS discount,"
		." IFNULL((100 - discount) * (price / 100), 0) AS salePrice"
		." FROM productsales ps JOIN"
		." product p on ps.productId = p.id"
		." JOIN variation v ON p.id = v.productId"
		." JOIN size s on v.id = s.variantId ".$strSize
		." LEFT JOIN (select vr.productId, COUNT(vr.id) as color from variation vr group by vr.productId) as vc"
		." ON vc.productId = p.id"
		." LEFT JOIN salespromotion sp ON ps.salesid = sp.id"
		." and CURRENT_TIMESTAMP() BETWEEN sp.timeStart AND sp.timeEnd ". $strCate ." WHERE ps.salesid = ".$salesId
		." GROUP BY p.id , name , price , discount , salePrice"
		." ORDER BY -p.id ".$strLimit;
		
		return (array) DB::select(DB::raw($query));
	}

	public function get_productsSale($salesId, $size, $cateId, $start){
		$result = array();

		$result["products"] = $this->productsSale($salesId, $size, $cateId, $start);
		$result["total"] = count($this->productsSale($salesId, $size, $cateId, -1));

		return $result;
	}
}
