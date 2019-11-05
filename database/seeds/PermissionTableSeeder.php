<?php

use App\Models\Permission;
use App\Models\PermissionParent;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // zdefiniowanie operacji CRUD
        $CRUD = [
            'CREATE',
            'INDEX',
            'EDIT',
            'DELETE'
        ];

        // tworzenie kategorii uprawnień
        $parents[] = factory(PermissionParent::class)->create([
            'name' => 'Users',
            'translation_key' => 'USERS.USERS'
        ]);
        $parents[] = factory(PermissionParent::class)->create([
            'name' => 'Roles',
            'translation_key' => 'ROLES.ROLES'
        ]);

        // tworzenie podkategorii uprawnień - CRUD
        foreach ($parents as $parent) {
            for ($i = 0; $i < 4; $i++) {
                $usersPermissions[$parent->id][] = factory(Permission::class)->create([
                    'name' => ucfirst(strtolower($CRUD[$i])),
                    'translation_key' => 'CRUD' . '.' . $CRUD[$i],
                    'permission_parent_id' => $parent->id
                ]);
            }
        }

        // tworzenie uprawnień dla wszystkich ról
        $roles = Role::all();

        foreach ($roles as $role) {
            foreach ($usersPermissions as $userPermission) {
                foreach ($userPermission as $permission) {
                    factory(PermissionRole::class)->create([
                        'permission_id' => $permission->id,
                        'role_id' => $role->id,
                        'selected' => 1
                    ]);
                }
            }
        }
    }
}
