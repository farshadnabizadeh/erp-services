<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemModule extends Model
{
    use HasFactory;
    protected $fillable = [
        "slug",
        "name",
        "default_config",
        "description",
        "is_active",
    ];

    protected $casts = [
        "default_config" => 'array',
        "is_active" => 'boolean',
    ];

    public function userModules()
    {
        return $this->hasMany(UserModule::class);
    }
}
