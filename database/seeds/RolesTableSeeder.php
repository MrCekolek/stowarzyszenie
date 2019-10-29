<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // generowanie roli w systemie - admin
        factory(Role::class)->create([
            'name' => 'admin'
        ]);

        // generowanie roli w systemie - user
        factory(Role::class)->create([
           'name' => 'user'
        ]);
    }
}
