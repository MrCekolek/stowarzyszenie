<?php

use App\Models\Permission;
use App\Models\PermissionParent;
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

        // zdefiniowanie kategorii uprawnien
        $permissionParents = PermissionParent::permissionParents();

        // dodanie kategorii uprawnien i operacji CRUD
        foreach ($permissionParents as $permissionParent) {
            $parent = factory(PermissionParent::class)->create([
                'name' => $permissionParent['name'],
                'translation_key' => $permissionParent['translation_key']
            ]);

            // dodanie operacji crud do kategorii
            foreach ($CRUD as $permission) {
                factory(Permission::class)->create([
                    'name' => ucfirst(strtolower($permission)),
                    'translation_key' => 'CRUD' . '.' . $permission,
                    'permission_parent_id' => $parent->id
                ]);
            }

            // sprawdzenie i dodanie reszty uprawnien do kategorii
            if (isset(Permission::permissions()[$parent->name])) {
                foreach (Permission::permissions()[$parent->name] as $permission) {
                    factory(Permission::class)->create([
                        'name' => ucfirst(strtolower($permission[0]['name'])),
                        'translation_key' => $permission[0]['translation_key'],
                        'permission_parent_id' => $permission[0]['permission_parent_id']
                    ]);
                }
            }
        }
    }
}
