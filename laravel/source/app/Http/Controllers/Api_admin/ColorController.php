<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Get All Color
     * @OA\Get(
     *      path="/api/color",
     *      tags={"Color"},
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
        return Color::all();
    }

    /**
     * Add Category
     * @OA\Post(
     *      path="/api/color",
     *      tags={"Color"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *         )
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
        return Color::create($request->all());
    }

    /**
     * Get Color
     * @OA\Get(
     *      path="/api/color/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Color"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Color $color)
    {
        return $color;
    }

    /**
     * Update Category
     * @OA\Put(
     *      path="/api/color/{id}",
     *      tags={"Color"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="int",
     *         ),
     *          @OA\Property(
     *           property="name",
     *           type="string",
     *         )
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
    public function update(Request $request, $color)
    {
        $color->update($request->all());
        return $color;
    }

    /**
     * Delete Color
     * @OA\Delete(
     *      path="/api/color/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Color"},
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
        $color = Color::find($id);
        $color->deleted = 1;
        $rs = $color->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
