<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SalesPromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;


class SalesPromotionRepository implements SalesPromotionRepositoryInterface
{

	/**
	 * @param mixed $salesId
	 * @param mixed $start
	 * @return mixed
	 */
	public function get_sales($salesId, $start) {
        $query = "select id, name, mobileBanner, pcBanner"
        ." FROM salespromotion"
        ." WHERE visible = 1 AND CURRENT_TIMESTAMP() BETWEEN timeStart AND timeEnd"
        ." and id = ".$salesId;

        $result = DB::select(DB::raw($query));

        return $result;
	}

    public function get_sale(){
        $query = "select id, name"
        ." FROM salespromotion"
        ." WHERE visible = 1 AND CURRENT_TIMESTAMP() BETWEEN timeStart AND timeEnd";

        return (array) DB::select(DB::raw($query));
    }

    public function get_sale_banner(){
        $query = "select id, name, mobileBanner, pcBanner, 'sale' AS type"
        ." FROM salespromotion"
        ." WHERE visible = 1 AND CURRENT_TIMESTAMP() BETWEEN timeStart AND timeEnd";

        return (array) DB::select(DB::raw($query));
    }
}