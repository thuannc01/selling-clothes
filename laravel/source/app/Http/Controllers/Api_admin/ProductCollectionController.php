<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCollection;

class ProductCollectionController extends Controller
{
    /**
     * Get All ProductCollection
     * @OA\Get(
     *      path="/api/productcollection",
     *      tags={"ProductCollection"},
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
        return ProductCollection::all();
    }


    /**
     * Add ProductCollection
     * @OA\Post(
     *      path="/api/productcollection",
     *      tags={"ProductCollection"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="productId",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="collectionId",
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
        return ProductCollection::create($request->all());
    }

    /**
     * Get ProductCollection
     * @OA\Get(
     *      path="/api/productcollection/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"ProductCollection"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(ProductCollection $productCollection)
    {
        return $productCollection;
    }

    /**
     * Update ProductCollection
     * @OA\Put(
     *      path="/api/productcollection/{id}",
     *      tags={"ProductCollection"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="productId",
     *           type="int",
     *         ),
     *         @OA\Property(
     *           property="collectionId",
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
    public function update(Request $request, $productCollection)
    {
        $productCollection->update($request->all());
        return $productCollection;
    }

    /**
     * Delete ProductCollection
     * @OA\Delete(
     *      path="/api/productcollection/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"ProductCollection"},
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
        $productCollection = category::find($id);
        $productCollection->deleted = 1;
        $rs = $productCollection->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
