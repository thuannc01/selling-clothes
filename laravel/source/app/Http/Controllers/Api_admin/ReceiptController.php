<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    /**
     * Get All Receipt
     * @OA\Get(
     *      path="/api/receipt",
     *      tags={"Receipt"},
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
        return Receipt::all();
    }

    /**
     * Add Receipt
     * @OA\Post(
     *      path="/api/receipt",
     *      tags={"Receipt"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="user_id",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="timeOrder",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="paymentTime",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="paymentMethod",
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
        return Receipt::create($request->all());
    }

    /**
     * Get Receipt
     * @OA\Get(
     *      path="/api/receipt/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Receipt"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Receipt $receipt)
    {
        return $receipt;
    }

    /**
     * Update Receipt
     * @OA\Put(
     *      path="/api/receipt/{id}",
     *      tags={"Receipt"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="int",
     *         ),
     *        @OA\Property(
     *           property="user_id",
     *           type="string",
     *         ),
     *      @OA\Property(
     *           property="timeOrder",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="paymentTime",
     *           type="datetime",
     *         ),
     *       @OA\Property(
     *           property="paymentMethod",
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
    public function update(Request $request, $receipt)
    {
        $receipt->update($request->all());
        return $receipt;
    }

    /**
     * Delete Receipt
     * @OA\Delete(
     *      path="/api/receipt/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Receipt"},
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
        $receipt = Receipt::find($id);
        $receipt->deleted = 1;
        $rs = $receipt->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
