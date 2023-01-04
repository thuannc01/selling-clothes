<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variation;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Get All Product
     * @OA\Get(
     *      path="/api/product",
     *      tags={"Product"},
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
        return Product::all();
    }


    /**
     * Add Producy
     * @OA\Post(
     *      path="/api/product",
     *      tags={"Product"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="price",
     *           type="float",
     *         ),
     *       @OA\Property(
     *           property="description",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="img",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="categoryId",
     *           type="integer",
     *         ),
     *       @OA\Property(
     *           property="deleted",
     *           type="int",
     *         ),
     *      @OA\Property(
     *          type="array",
     *          property="variant",
     *          @OA\Items(
     *                  @OA\Property(
     *                      property="colorId",
     *                      type="int",
     *                  ),
     *                  @OA\Property(
     *                      property="thumbnail",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="deleted",
     *                      type="int",
     *                  ),
     *                  @OA\Property(
     *                      type="array",
     *                      property="sizes",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="size",
     *                              type="integer",
     *                          ),
     *                          @OA\Property(
     *                              property="quantity",
     *                              type="integer",
     *                          ),
     *                          @OA\Property(
     *                              property="deleted",
     *                              type="integer",
     *                          )
     *                      )
     *                  )
     * 
     *              )
     *          )
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
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->img = $request->img;
        $product->categoryId = $request->categoryId;
        $product->deleted = $request->deleted;

        $product->save();

        $listVariant = $request->variant;
        foreach ($listVariant as $item) {
            $variant = new Variation();
            $variant->productId = $product->id;
            $variant->colorId = $item["colorId"];
            $variant->thumbnail = $item["thumbnail"];
            $variant->deleted = $item["deleted"];

            $variant->save();

            $listSize = $item["sizes"];
            foreach ($listSize as $s) {
                $sizeVariant = new Size();
                $sizeVariant->variantId = $variant->id;
                $sizeVariant->size = $s["size"];
                $sizeVariant->quantity = $s["quantity"];
                $sizeVariant->deleted = $s["deleted"];

                $sizeVariant->save();
            }
        }
    }

    /**
     * Get Product
     * @OA\Get(
     *      path="/api/product/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          description="",
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Product"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show($id)
    {
        return Product::find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete Product
     * @OA\Delete(
     *      path="/api/product/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Product"},
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
        $product = Product::find($id);
        $product->deleted = 1;
        $rs = $product->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
