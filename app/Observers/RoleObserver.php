<?php

namespace App\Observers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;

class RoleObserver
{
    /**
     * Handle the role "created" event.
     *
     * @param Role $role
     * @return void
     */
    public function created(Role $role)
    {
        foreach (Permission::all() as $permission) {
            factory(PermissionRole::class)->create([
                'permission_id' => $permission->id,
                'role_id' => $role->id,
                'selected' => $role->name === 'admin' ? 1 : 0
            ]);
        }
    }

    /**
     * Handle the role "updated" event.
     *
     * @param Role $role
     * @return void
     */
    public function updated(Role $role)
    {
        //
    }

    /**
     * Handle the role "deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }

    /**
     * Handle the role "restored" event.
     *
     * @param Role $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the role "force deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
