<?php

namespace App\Contracts\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface MenuBuilderServiceInterface
{
    public function buildMenus(int $userId): AnonymousResourceCollection;
}
