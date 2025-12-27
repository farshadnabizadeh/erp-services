<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Contracts\Services\MenuBuilderServiceInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected MenuBuilderServiceInterface $menuService;

    public function __construct(MenuBuilderServiceInterface $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(Request $request)
    {
        $menu = $this->menuService->buildMenus($request->user()->id);
        return response()->json(['data' => $menu]);
    }
}
