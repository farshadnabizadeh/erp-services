<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface UserModuleRepositoryInterface
{
    public function getTreeByUser(int $userId): Collection;
}
