<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Get All Image
     * @OA\Get(
     *      path="/api/image",
     *      tags={"Image"},
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
        return Image::all();
    }

    /**
     * Add Image
     * @OA\Post(
     *      path="/api/image",
     *      tags={"Image"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="url",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="variantId",
     *           type="int",
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
        return Image::create($request->all());
    }

    /**
     * Get Image
     * @OA\Get(
     *      path="/api/image/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Image"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Image $image)
    {
        return $image;
    }

    /**
     * Update Image
     * @OA\Put(
     *      path="/api/image/{id}",
     *      tags={"Image"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="url",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="variantId",
     *           type="int",
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
    public function update(Request $request, $image)
    {
        $image->update($request->all());
        return $image;
    }

    /**
     * Delete Image
     * @OA\Delete(
     *      path="/api/image/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Image"},
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
        $image = category::find($id);
        $image->deleted = 1;
        $rs = $image->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
