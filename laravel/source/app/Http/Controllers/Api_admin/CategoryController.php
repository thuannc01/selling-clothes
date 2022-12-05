<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="My First API", version="0.1")
 */

class CategoryController extends Controller
{
    /**
     * Get All Category
     * @OA\Get(
     *      path="/api/category",
     *      tags={"Category"},
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
        // dd(category::all());
        return category::all();
    }

    /**
     * Tìm kiếm danh mục theo tên
     * @OA\Get(
     *      path="/api/searchCategory/{name}",
     *      @OA\Parameter(
     *          name="name",
     *          in="path",
     *          required=false,
     *          description="Tìm kiếm danh mục theo tên",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *      tags={"Category"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function getAllDanhMuc($name)
    {
        return category::where('name', 'like', '%' . $name . '%')->get();
    }

    /**
     * Add Category
     * @OA\Post(
     *      path="/api/category",
     *      tags={"Category"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="visible",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="text",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="img",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="parentsId",
     *           type="integer",
     *         ),
     *       @OA\Property(
     *           property="deleted",
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
    public function store(Request $request)
    {
        return category::create($request->all());
    }

    /**
     * Get Category
     * @OA\Get(
     *      path="/api/category/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          description="The event ID specific to this event",
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Category"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(category $category)
    {
        return $category;
    }

    /**
     * Update Category
     * @OA\Put(
     *      path="/api/category",
     *      tags={"Category"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="visible",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="text",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="img",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="parentsId",
     *           type="integer",
     *         ),
     *       @OA\Property(
     *           property="deleted",
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
    public function update(CategoryRequest $request, category $category)
    {
        return $category->update($request->all());
        return $category;
    }

    /**
     * Get Category
     * @OA\Delete(
     *      path="/api/category/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          description="The event ID specific to this event",
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Category"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function destroy($id)
    {
        // $category->delete();
        $category = category::find($id);
        $category->deleted = 1;
        $rs = $category->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }

    public function visible($id)
    {
        $category = category::find($id);
        $visible = 0;
        if ($category->visible == 0) {
            $visible = 1;
        }
        $category->visible = $visible;
        $rs = $category->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
