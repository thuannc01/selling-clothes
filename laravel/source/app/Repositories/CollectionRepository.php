<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\CollectionInterface;

use App\Repositories\Interfaces\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class CollectionRepository implements CollectionRepositoryInterface
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository){
        $this->productRepository = $productRepository;
    }

    public function get_collection($collectionId, $start){
        $query = "select id, name, mobileBanner, pcBanner"
        ." FROM collection"
        ." WHERE visible = 1 and id = ".(string)$collectionId;

        $result = DB::select(DB::raw($query));

        if (isset($result)){
            $collection = $result[0];
        }

        $collection["products"] = $this->productRepository->get_productsCollection($collectionId, $start);
        $collection["total"] = count($this->productRepository->get_productsCollection($collectionId, -1));

        return $collection;
    }
}