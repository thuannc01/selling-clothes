<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(\App\Repositories\Interfaces\ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get All Product Client
     * @OA\Get(
     *      path="/api/products",
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

    public function index()
    {
        $products = $this->productRepository->all();

        return response(
            [
                'data'=> $products
            ]
        );
    }

    /**
     * Get Weekly Best Products
     * @OA\Get(
     *      path="/api/products/weekly_best?limit={limit}&cateId={cateId}",
     * @OA\Parameter(
     *          name="limit",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="cateId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_weekly_best_product(Request $request)
    {
        try{
            if($request->limit == "," || $request->cateId == ","){
                $request->limit = 10;
                $request->cateId = 0;
            }
            $products = $this->productRepository->get_weekly_best_product($request->limit, $request->cateId);
            return response(
                [
                    'data'=>$products
                ]
            );
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        }
    }

    /**
     * Get new products
     * @OA\Get(
     *      path="/api/products/new_products?limit={limit}&cateId={cateId}",
     * @OA\Parameter(
     *          name="limit",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="cateId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

    public function get_new_product(Request $request)
    {

        try{
            if($request->limit == "," || $request->cateId == ","){
                $request->limit = 10;
                $request->cateId = 0;
            }
            $products = $this->productRepository->get_new_product($request->limit, $request->cateId);
            return response(
                [
                    'data'=>$products
                ]
            );
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }

    /**
     * Search for products
     * @OA\Get(
     *      path="/api/products/search?searchStr={searchStr}&limit={limit}",
     * @OA\Parameter(
     *          name="searchStr",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="limit",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

    public function search_products(Request $request){
        try{
            $products = $this->productRepository->search_products($request->searchStr, $request->limit);
            return response(
                [
                    'data'=>$products
                ]
            );
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }
}
