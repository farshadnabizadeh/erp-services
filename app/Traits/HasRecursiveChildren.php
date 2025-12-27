<?php

namespace App\Traits;

trait HasRecursiveChildren
{
    public function parent()
    {
        return $this->belongsTo(static::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(static::class, "parent_id")->orderBy('sort_order');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
