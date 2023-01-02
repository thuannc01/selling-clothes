<?php

namespace App\Repositories\Interfaces;

use App\Models\Collection;


interface CollectionRepositoryInterface
{
    public function get_collection($collectionId, $start);
}