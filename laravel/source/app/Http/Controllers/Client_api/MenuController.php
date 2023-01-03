<?php

namespace App\Http\Controllers\Client_api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MenuRepositoryInterface;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class MenuController extends Controller
{
    protected $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Get menu
     * @OA\Get(
     *      path="/api/menu",
     *      tags={"Menu Client"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    public function get_menu(){
        try{
            $menu = $this->menuRepository->get_menu();
            return response($menu);
        }
        catch(Exception $e){
            return response([
                'status'=>'Bad Request'
            ]);
        }
    }
}
