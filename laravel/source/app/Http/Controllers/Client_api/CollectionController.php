<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use App\Repositories\CollectionRepository;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class CollectionController extends Controller
{
    protected $collectionRepository;

    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * Get Collection
     * @OA\Get(
     *      path="/api/collections?collectionId={collectionId}&start={start}",
     * @OA\Parameter(
     *          name="collectionId",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     * @OA\Parameter(
     *          name="start",
     *          in="path",
     *          required=false,
     *          @OA\Schema(
     *              type="int"
     *          ),
     *     ),
     *      tags={"Collection Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_collection(Request $request){
        try{
            $collection = $this->collectionRepository->get_collection($request->collectionId, $request->start);
            return response($collection);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        }
    }
}
