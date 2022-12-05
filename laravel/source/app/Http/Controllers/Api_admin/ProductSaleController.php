<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSale;

class ProductSaleController extends Controller
{
    /**
     * Get All ProductSale
     * @OA\Get(
     *      path="/api/productsale",
     *      tags={"ProductSale"},
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
        return ProductSale::all();
    }

    /**
     * Add ProductSale
     * @OA\Post(
     *      path="/api/productsale",
     *      tags={"ProductSale"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="productid",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="saleid",
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
        return ProductSale::create($request->all());
    }

    /**
     * Get ProductSale
     * @OA\Get(
     *      path="/api/productsale/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"ProductSale"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(ProductSale $productSale)
    {
        return $productSale;
    }



    /**
     * Update ProductSale
     * @OA\Put(
     *      path="/api/productsale/{id}",
     *      tags={"ProductSale"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="productid",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="saleid",
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
    public function update(Request $request, $productSale)
    {
        $productSale->update($request->all());
        return $productSale;
    }

    /**
     * Delete ProductSale
     * @OA\Delete(
     *      path="/api/productsale/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"ProductSale"},
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
        $productSale = ProductSale::find($id);
        $productSale->deleted = 1;
        $rs = $productSale->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
