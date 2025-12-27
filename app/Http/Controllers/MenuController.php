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
        // Get authenticated user ID, fallback to 1 for development/testing
        $userId = $request->user()?->id ?? 1;
        
        $menu = $this->menuService->buildMenus($userId);
        return response()->json(['data' => $menu]);
    }
}
