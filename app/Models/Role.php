<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['roleName', 'permission', 'description', 'isAdmin'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
    public function allows(string $resource, string $action): bool
    {
        $permissions = json_decode($this->permission ?? '[]', true);
        if (!is_array($permissions)) {
            return false;
        }
        foreach ($permissions as $permission) {
            if (is_array($permission) && ($permission['name'] ?? null) === $resource && ($permission[$action] ?? false) === true) {
                return true;
            }
        }
        return false;
    }

    public function hasAnyPermission(string $action): bool
    {
        foreach (['releves', 'releveurs', 'adminusers', 'roles', 'assignRole', 'historique'] as $resource) {
            if ($this->allows($resource, $action)) {
                return true;
            }
        }
        return false;
    }
}
