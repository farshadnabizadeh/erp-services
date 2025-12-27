<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasRecursiveChildren;

class UserModule extends Model
{
    use HasFactory, HasRecursiveChildren;
    protected $fillable = [
        'user_id',
        'system_module_id',
        'parent_id',
        'custom_name',
        'settings',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function systemModule()
    {
        return $this->belongsTo(SystemModule::class);
    }
}
