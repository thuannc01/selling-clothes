<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use App\Models\DetailReceipt;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variation;
use App\Models\Image;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get All Product
     * @OA\Get(
     *      path="/api/product",
     *      @OA\Parameter(
     *          name="keyword",
     *          in="query",
     *          required=false,
     *          description="",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="pageSize",
     *          in="query",
     *          required=false,
     *          description="",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      tags={"Product"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function index(Request $request)
    {
        // return Product::all();
        $pageSize = 10;
        if ($request->pageSize) {
            $pageSize = $request->pageSize;
        }
        $listProduct = DB::table('product')
            ->join('category', 'product.categoryId', '=', 'category.Id')
            ->where('product.deleted', '=', 0)
            ->where('product.name', 'LIKE', '%' . $request->keyword . '%')
            ->select('product.*', 'category.name AS categoryName')
            ->paginate($pageSize);
        return $listProduct;
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
     *                  ),
     *                  @OA\Property(
     *                      type="array",
     *                      property="images",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="url",
     *                              type="string",
     *                          ),
     *                          @OA\Property(
     *                              property="deleted",
     *                              type="integer",
     *                          )
     *                      )
     *                  ),
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

            $listImage = $item["images"];
            foreach ($listImage as $img) {
                $image = new Image();
                $image->variantId = $variant->id;
                $image->url = $img["url"];
                $image->deleted = $img["deleted"];

                $image->save();
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
        // return Product::find($id);
        $product = DB::table('product')
            ->where('product.id', '=', $id)->first();

        $variants = DB::table('variation')
            ->join('color', 'variation.colorId', '=', 'color.Id')
            ->where('variation.productId', '=', $product->id)
            ->select('variation.*', 'color.name AS colorName')->get();
        foreach ($variants as $variant) {
            $variant->Sizes = DB::table('size')
                ->where('size.variantId', '=', $variant->id)->get();
            $variant->Images = DB::table('image')
                ->where('image.variantId', '=', $variant->id)->get();
        }
        $product->Variants = $variants;
        return $product;
    }


    /**
     * Update Producy
     * @OA\Put(
     *      path="/api/product/{id}",
     *      tags={"Product"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="int",
     *         ),
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
    public function update(Request $request, $id)
    {
        $product = Product::find($request->id);

        //delete variant, size, image
        $variants = DB::table('variation')
            ->where('variation.productId', '=', $product["id"])->get();

        foreach ($variants as $variant) {

            $oldVariant = Variation::find($variant->id);
            $oldVariant->deleted = 1;
            $oldVariant->save();

            DB::table('size')
                ->where('size.variantId', '=', $variant->id)->delete();

            DB::table('image')
                ->where('image.variantId', '=', $variant->id)->delete();
        }

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
