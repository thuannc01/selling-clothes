<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BannerRepositoryInterface;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class BannerController extends Controller
{
    protected $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Get banner
     * @OA\Get(
     *      path="/api/banner",
     *      tags={"Banner Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_banner(){
        try{
            $banner = $this->bannerRepository->get_banner();
            return response($banner);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        }
    }
}
