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
        $CRUD = Permission::CRUD();

        // zdefiniowanie reszty operacji
        $permissions = Permission::permissions();

        // zdefiniowanie kategorii uprawnien
        $permissionParents = PermissionParent::permissionParents();

        // dodanie kategorii uprawnien i operacji CRUD
        foreach ($permissionParents as $permissionParent) {
            $parents[] = factory(PermissionParent::class)->create([
                'name' => $permissionParent['name'],
                'translation_key' => $permissionParent['translation_key']
            ]);

            // dodanie operacji crud do kategorii
            foreach ($CRUD as $permission) {
                $allPermissions[] = factory(Permission::class)->create([
                    'name' => ucfirst(strtolower($permission)),
                    'translation_key' => 'CRUD' . '.' . $permission,
                    'permission_parent_id' => last($parents)
                ]);
            }

            // sprawdzenie i dodanie reszty uprawnien do kategorii
            if (isset(Permission::permissions()[last($parents)['name']])) {
                foreach (Permission::permissions()[last($parents)['name']] as $permission) {
                    $allPermissions[] = factory(Permission::class)->create([
                        'name' => ucfirst(strtolower($permission[0]['name'])),
                        'translation_key' => $permission[0]['translation_key'],
                        'permission_parent_id' => $permission[0]['permission_parent_id']
                    ]);
                }
            }
        }
    }
}
