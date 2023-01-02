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
            return response($products);
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
            return response($products);
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
            return response($products);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }

    /**
     * Get max price
     * @OA\Get(
     *      path="/api/max-price",
     *      tags={"Product Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_max_price(){
        try{
            $max_price = $this->productRepository->get_max_price();
            return response($max_price);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }

    /**
     * Get product collection 
     * @OA\Get(
     *      path="/api/productsCollection?collectionId={collectionId}&start={start}",
     * @OA\Parameter(
     *          name="collectionId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="start",
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
    public function get_productsCollection(Request $request){
        try{
            $product_collection = $this->productRepository->get_productsCollection($request->collectionId, $request->start);
            return response($product_collection);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }
}
