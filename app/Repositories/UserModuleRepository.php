<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserModuleRepositoryInterface;
use App\Models\UserModule;
use Illuminate\Database\Eloquent\Collection;


class UserModuleRepository implements UserModuleRepositoryInterface
{
    public function getTreeByUser(int $userId): Collection
    {
        return UserModule::query()
            ->with(['systemModule', 'children.systemModule'])
            ->where('user_id', $userId)
            ->whereNull('parent_id') // Get only Roots
            ->orderBy('sort_order')
            ->get();
    }
}
