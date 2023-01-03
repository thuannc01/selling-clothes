<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface;
use App\Repositories\Interfaces\SalesPromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MenuRepository implements MenuRepositoryInterface
{
    protected $salesPromotionRepository, $categoryRepository, $collectionRepository;
    
    public function __construct(SalesPromotionRepositoryInterface $salesPromotionRepository,
     CategoryRepositoryInterface $categoryRepository,
     CollectionRepositoryInterface $collectionRepository){

        $this->salesPromotionRepository = $salesPromotionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->collectionRepository = $collectionRepository;
    }
    public function get_menu()
    {
        $saleList = array();
        $cateList = array();
        $collectionList = array();
        
        foreach ($this->salesPromotionRepository->get_sale() as $key => $value){
            $saleList[$key] = array(
                'id'=>$value->id, 
                'name'=>$value->name,
                'type'=>'sale');
        }

        foreach ((array)$this->categoryRepository->get_categories() as $key => $value){
            $cateList[$key] = array(
                'id'=>$value->id, 
                'name'=>$value->name,
                'type'=>$value->type,
                'children'=>(array)$this->categoryRepository->get_subcate($value->id));
        }

        foreach ((array)$this->collectionRepository->get_collections() as $key => $value){
            $collectionList[$key] = array(
                'id' => $value->id,
                'name' => $value->name,
                'type' => 'collection');
        }

        (array)$x = array_merge($saleList, $cateList);
        (array)$y = array_merge($x, $collectionList);

        return $y;
    }
}