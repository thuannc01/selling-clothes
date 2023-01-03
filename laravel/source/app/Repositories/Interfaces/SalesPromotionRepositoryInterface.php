<?php

namespace App\Repositories\Interfaces;

use App\Models\SalePromotion;


interface SalesPromotionRepositoryInterface
{
    public function get_sales($salesId, $start);
}