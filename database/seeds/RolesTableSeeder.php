<?php

use App\Models\Role;
use App\Traits\Translatable;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {
    use Translatable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // generowanie roli w systemie - admin
        $this->translate(
            'pl',
            'Administrator',
            (new Role()),
            'name'
        );

        $this->translate(
            'pl',
            'Użytkownik',
            (new Role()),
            'name'
        );

        $this->translate(
            'pl',
            'Test',
            (new Role()),
            'name'
        );
    }
}
