<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class SalesPromotionController extends Controller
{
    protected $salesPromotionRepository;

    public function __construct(\App\Repositories\Interfaces\SalesPromotionRepositoryInterface $salesPromotionRepository)
    {
        $this->salesPromotionRepository = $salesPromotionRepository;
    }

    /**
     * Get sales
     * @OA\Get(
     *      path="/api/sales?salesId={salesId}&start={start}",
     * @OA\Parameter(
     *          name="salesId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * * @OA\Parameter(
     *          name="start",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Sales Promotion Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_sales(Request $request){
        try{
            $sales = $this->salesPromotionRepository->get_sales($request->salesId, $request->start);
            return response($sales);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }
}
