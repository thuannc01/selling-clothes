<?php

namespace App\Repositories;

use App\Models\category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
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
        return (array)$result[0];
    }

    public function get_subcate($parentsId){
        $query = "select id, name, 'category' AS type FROM category WHERE parentsId = ".$parentsId;

        $result = (array)DB::select(DB::raw($query));

        if(count($result) == 0){
            $query2 = "select parentsId from category where id = " . $parentsId;
            $result = DB::select(DB::raw($query2));
            
            if(count((array)$result)!= 0){
                $parentsId = $result[0]->parentsId;
            } else {
                $parentsId = 0;
            }
            
            $result = DB::select(DB::raw("select id, name, 'category' AS type FROM category WHERE parentsId = ".$parentsId));
        }
        return $result;
    }
}