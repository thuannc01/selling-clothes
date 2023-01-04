<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get Category
     * @OA\Get(
     *      path="/api/categories",
     *      tags={"Category Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

    public function get_category()
    {
        $category = $this->categoryRepository->get_categories();

        return response($category);
    }

    /**
     * Get Category detail
     * @OA\Get(
     *      path="/api/categories/detail?cateId={cateId}",
     * @OA\Parameter(
     *          name="cateId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Category Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */

    public function get_category_detail(Request $request){
        $category = $this->categoryRepository->get_categories_detail($request->cateId);
        
        return response($category);
    }

    /**
     * Get subcategory 
     * @OA\Get(
     *      path="/api/categories/children?parentsId={parentsId}",
     * @OA\Parameter(
     *          name="parentsId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Category Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_subcate(Request $request){
        try{
            $sub_cate = $this->categoryRepository->get_subcate($request->parentsId);
            return response($sub_cate);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        }
    }
}
