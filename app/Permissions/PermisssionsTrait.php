<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.5.18.
 * Time: 10.36
 */

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

/**
 * Trait PermissionsTrait
 * @package App\Permissions
 */
trait PermissionsTrait
{

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermission($permission)
    {
        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

}