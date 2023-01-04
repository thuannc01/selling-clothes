<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailReceipt;

class DetailReceiptController extends Controller
{
    /**
     * Get All DetailReceipt
     * @OA\Get(
     *      path="/api/detailreceipt",
     *      tags={"DetailReceipt"},
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
        return DetailReceipt::all();
    }

    /**
     * Add DetailReceipt
     * @OA\Post(
     *      path="/api/detailreceipt",
     *      tags={"DetailReceipt"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="receiptId",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="variantId",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="price",
     *           type="double",
     *         ),
     *       @OA\Property(
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
        return DetailReceipt::create($request->all());
    }

    /**
     * Get DetailReceipt
     * @OA\Get(
     *      path="/api/detailreceipt/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"DetailReceipt"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(DetailReceipt $detailReceipt)
    {
        return $detailReceipt;
    }

    /**
     * Update DetailReceipt
     * @OA\Put(
     *      path="/api/detailreceipt/{id}",
     *      tags={"DetailReceipt"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="receiptId",
     *           type="int",
     *         ),
     *      @OA\Property(
     *           property="variantId",
     *           type="int",
     *         ),
     *       @OA\Property(
     *           property="price",
     *           type="double",
     *         ),
     *       @OA\Property(
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
    public function update(Request $request, $detailReceipt)
    {
        $detailReceipt->update($request->all());
        return $detailReceipt;
    }

    /**
     * Delete DetailReceipt
     * @OA\Delete(
     *      path="/api/detailreceipt/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"DetailReceipt"},
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
        $detailReceipt = DetailReceipt::find($id);
        $detailReceipt->deleted = 1;
        $rs = $detailReceipt->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
