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
     * Get Product By Category
     * @OA\Post(
     *      path="/api/products/filter",
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     * @OA\RequestBody(
     *     required=false,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="cateId",
     *           type="string",
     *         ),
     *  	   @OA\Property(
     *           property=" start",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="colors",
     *           type="list",
     *         ),
     *       @OA\Property(
     *           property=" sizes",
     *           type="list",
     *         ),
     *       @OA\Property(
     *           property="sort",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="price",
     *           type="list",
     *         ),
     *       @OA\Property(
     *           property="limit",
     *           type="int",
     *         ),
     *       ),
     *     ),
     *   ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    
    public function product_filter(Request $request)
    {
        $products = $this->productRepository->product_filter($request->cateId, $request->start, $request->colors, $request->sizes, $request->sort, $request->price, $request->limit);

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
        
        $products = $this->productRepository->get_new_product($request->limit, $request->cateId);
        
        return response(
            [
                'data'=>$products
            ]
        );
    }
}
