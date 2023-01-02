<?php

namespace App\Repositories;

use App\Models\category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    
	/**
	 * @return mixed
	 */
	public function get_categories() {
        $query = "select id, name, text, img, 'category' AS type"
            . " FROM category"
            . " WHERE visible = 1 and id in (select parentsId from category)";

        $category = DB::select(DB::raw($query));        

        return $category;
	}

    public function get_categories_detail($cateId){
        $query = "select id, name, text"
        . " FROM category"
        . " WHERE id = " .(string)$cateId;

        $result = DB::select(DB::raw($query));
        if($result == null){
            return ;
        }
        return $result;
    }
}