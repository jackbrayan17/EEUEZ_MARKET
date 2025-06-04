<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole; // Extend from Spatie's Role model
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends SpatieRole
{
    use HasRoles;

    protected $fillable = ['name'];


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles'); 
    }
}
