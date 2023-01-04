<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;

class VariantionController extends Controller
{
    /**
     * Get All Variation
     * @OA\Get(
     *      path="/api/variation",
     *      tags={"Variation"},
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
        return Variation::all();
    }


    /**
     * Add Variation
     * @OA\Post(
     *      path="/api/variation",
     *      tags={"Variation"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="productId",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="colorId",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="thumbnail",
     *           type="string",
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
        return Variation::create($request->all());
    }

    /**
     * Get Variation
     * @OA\Get(
     *      path="/api/variation/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Variation"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Variation $variation)
    {
        return $variation;
    }


    /**
     * Update Variation
     * @OA\Put(
     *      path="/api/variation/{id}",
     *      tags={"Variation"},
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
     *           property="productId",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="colorId",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="thumbnail",
     *           type="string",
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
    public function update(Request $request, $variation)
    {
        $variation->update($request->all());
        return $variation;
    }

    /**
     * Delete Variation
     * @OA\Delete(
     *      path="/api/variation/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Variation"},
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
        $variation = category::find($id);
        $variation->deleted = 1;
        $rs = $variation->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
