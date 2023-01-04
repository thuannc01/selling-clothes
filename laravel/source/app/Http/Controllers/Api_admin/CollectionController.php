<?php

namespace App\Http\Controllers\Api_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    /**
     * Get All Collection
     * @OA\Get(
     *      path="/api/collection",
     *      tags={"Collection"},
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
        return Collection::all();
    }

    /**
     * Add Collection
     * @OA\Post(
     *      path="/api/collection",
     *      tags={"Collection"},
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
        return Collection::create($request->all());
    }

    /**
     * Get Collection
     * @OA\Get(
     *      path="/api/collection/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Collection"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function show(Collection $collection)
    {
        return $collection;
    }

    /**
     * Update Collection
     * @OA\Put(
     *      path="/api/collection/{id}",
     *      tags={"Collection"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="id",
     *           type="int",
     *         ),
     *          @OA\Property(
     *           property="name",
     *           type="string",
     *         ),
     *      @OA\Property(
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
    public function update(Request $request, $collection)
    {
        $collection->update($request->all());
        return $collection;
    }

    /**
     * Delete Collection
     * @OA\Delete(
     *      path="/api/collection/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Collection"},
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
        $collection = Collection::find($id);
        $collection->deleted = 1;
        $rs = $collection->save();
        if ($rs) {
            return "200";
        } else {
            return "500";
        }
    }
}
