<?php

namespace App\Repositories\Interfaces;

use App\Models\category;


interface CategoryRepositoryInterface
{
    public function get_categories();

    public function get_categories_detail($cateId);

    public function get_subcate($parentsId);
}