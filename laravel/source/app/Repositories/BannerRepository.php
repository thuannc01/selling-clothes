<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BannerRepositoryInterface;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use App\Repositories\Interfaces\SalesPromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BannerRepository implements BannerRepositoryInterface
{
    
	/**
	 * @return mixed
	 */

     protected $salesPromotionRepository, $collectionRepository;
    
     public function __construct(SalesPromotionRepositoryInterface $salesPromotionRepository,
      CollectionRepositoryInterface $collectionRepository){
 
         $this->salesPromotionRepository = $salesPromotionRepository;
         $this->collectionRepository = $collectionRepository;
     }
    
	public function get_banner() {
        $bannerList = array();
        $result = array();

        $bannerList = $this->salesPromotionRepository->get_sale_banner();
        $result = array_merge($bannerList,$this->collectionRepository->get_collection_banner());

        return $result;
	}
}