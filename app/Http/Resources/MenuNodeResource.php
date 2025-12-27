<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuNodeResource extends JsonResource
{
    public function toArray($request)
    {
        $hasChildren = $this->children && $this->children->isNotEmpty();

        return [
            'id' => $this->id,
            'title' => $this->custom_name ?? $this->systemModule?->name ?? 'Untitled',
            'slug' => $this->systemModule?->slug ?? null,
            'icon' => $this->icon ?? null, // Assuming you have this
            'sort_order' => $this->sort_order,
            
            // Logic: Determine Type
            'type' => $hasChildren ? 'folder' : 'component',

            // Logic: Config Handling (SRP: Merging logic is encapsulated here or in a helper)
            'component_config' => $hasChildren 
                ? null // Folders have no config
                : $this->resolveConfiguration(), // Components get merged config
            
            // Recursive Call for Children
            'children' => $hasChildren ? MenuNodeResource::collection($this->children) : [],
        ];
    }

    /**
     * Helper to merge configs (SRP: Keep logic clean)
     */
    protected function resolveConfiguration()
    {
        $default = $this->systemModule?->default_config ?? [];
        $userOverride = $this->settings ?? [];

        return array_merge($default, $userOverride);
    }
}
