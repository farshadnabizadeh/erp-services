<?php

namespace App\Services;

use App\Contracts\Repositories\UserModuleRepositoryInterface;
use App\Contracts\Services\MenuBuilderServiceInterface;
use App\Http\Resources\MenuNodeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuBuilderService implements MenuBuilderServiceInterface
{
    protected $repository;

    /**
     * Dependency Injection:
     * We ask for the Interface (Contract), not the concrete class.
     * Laravel automatically injects the correct Repository implementation.
     */
    public function __construct(UserModuleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Build the menu tree for a specific user.
     * 
     * @param int $userId
     * @return AnonymousResourceCollection
     */
    public function buildMenus(int $userId): AnonymousResourceCollection
    {
        // 1. Get raw data from DB (Repository Responsibility)
        // This returns a collection of UserModule models with loaded relationships
        $rawTree = $this->repository->getTreeByUser($userId);

        // 2. Transform to API format (Resource Responsibility)
        // We pass the raw collection to the Resource.
        // The Resource handles the "Folder vs Component" logic and Config merging.
        return MenuNodeResource::collection($rawTree);
    }
}
