<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;
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
     * Get product filter
     * @OA\Post(
     *      path="/api/products/filter",
     *      tags={"Product Client"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="cateId",
     *           type="int",
     *         ),
     *        @OA\Property(
     *           property="start",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="colors",
     *           type="arr",
     *         ),
     *       @OA\Property(
     *           property="sizes",
     *           type="arr",
     *         ),
     *       @OA\Property(
     *           property="sort",
     *           type="string",
     *         ),
     * *       @OA\Property(
     *           property="price",
     *           type="arr",
     *         ),
     *       @OA\Property(
     *           property="limit",
     *           type="int",
     *         ),
     *       ),
     *     ),
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

     public function filter_products(Request $request){
        try{
            $products = $this->productRepository->product_filter($request->cateId, $request->start, $request->colors, 
            $request->sizes, $request->sort, $request->price, $request->limit);

            return response(
                [
                    'total'=> $products['total'],
                    'products'=>$products['products']
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
     * Get product detail
     * @OA\Get(
     *      path="/api/products/detail?productId={productId}",
     * @OA\Parameter(
     *          name="productId",
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
    public function get_product(Request $request){
        try{
            $products = $this->productRepository->get_product($request->productId);
            if(count((array)$products) > 0){
                return response($products);
            }
            return response()->json(new stdClass());
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
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

    /**
     * Get products for sale
     * @OA\Get(
     *      path="/api/productsSales?salesId={salesId}&size={size}&cateId={cateId}&start={start}",
     * @OA\Parameter(
     *          name="salesId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="size",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * * @OA\Parameter(
     *          name="cateId",
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
    public function get_productsSale(Request $request){
        try{
            $productsSale = $this->productRepository->get_productsSale($request->salesId, $request->size, $request->cateId, $request->start);
            return response($productsSale);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        } 
    }
}
