<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    /**
     * Get All Size
     * @OA\Get(
     *      path="/api/size",
     *      tags={"Size"},
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
        return DB::table('size')
            ->select('size')
            ->distinct()
            ->get();;
    }


    /**
     * Add Size
     * @OA\Post(
     *      path="/api/size",
     *      tags={"Size"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="variantId",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="size",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="quantity",
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
        return Size::create($request->all());
    }

    /**
     * Get Size
     * @OA\Get(
     *      path="/api/size/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Size"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Size $size)
    {
        return $size;
    }


    /**
     * Update Size
     * @OA\Put(
     *      path="/api/size/{id}",
     *      tags={"Size"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="variantId",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="size",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="quantity",
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
    public function update(Request $request, $size)
    {
        $size->update($request->all());
        return $size;
    }

    /**
     * Delete Size
     * @OA\Delete(
     *      path="/api/size/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Size"},
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
        $size = category::find($id);
        $size->deleted = 1;
        $rs = $size->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
