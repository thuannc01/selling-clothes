<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalePromotion;

class SalePromotionController extends Controller
{
    /**
     * Get All SalePromotion
     * @OA\Get(
     *      path="/api/salepromotion",
     *      tags={"SalePromotion"},
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
        return SalePromotion::all();
    }

    /**
     * Add SalePromotion
     * @OA\Post(
     *      path="/api/salepromotion",
     *      tags={"SalePromotion"},
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
     *           property="discount",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="timeStart",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="timeEnd",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="visible",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="mobileBanner",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="pcBanner",
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
        SalePromotion::create($request->all());
    }

    /**
     * Get SalePromotion
     * @OA\Get(
     *      path="/api/salepromotion/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"SalePromotion"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(SalePromotion $salePromotion)
    {
        return $salePromotion;
    }

    /**
     * Update SalePromotion
     * @OA\Put(
     *      path="/api/salepromotion/{id}",
     *      tags={"SalePromotion"},
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
     *           property="name",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="discount",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="timeStart",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="timeEnd",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="visible",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="mobileBanner",
     *           type="string",
     *         ),
     *       @OA\Property(
     *           property="pcBanner",
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
    public function update(Request $request, $salePromotion)
    {
        $salePromotion->update($request->all());
    }


    /**
     * Delete SalePromotion
     * @OA\Delete(
     *      path="/api/salepromotion/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"SalePromotion"},
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
        $salePromotion = SalePromotion::find($id);
        $salePromotion->deleted = 1;
        $rs = $salePromotion->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
