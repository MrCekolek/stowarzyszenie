<?php

namespace App\Observers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;

class RoleObserver {
    /**
     * Handle the role "created" event.
     *
     * @param Role $role
     * @return void
     */
    public function created(Role $role) {
        foreach (Permission::all() as $permission) {
            factory(PermissionRole::class)->create([
                'permission_id' => $permission->id,
                'role_id' => $role->id,
                'selected' => $role->name_pl === 'Administrator' ? 1 : 0
            ]);
        }
    }
}
