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
        foreach (Role::roles() as $role) {
            switch ($role) {
                case 'Track chair':
                    $this->translate(
                        'en',
                        $role,
                        (new Role()),
                        'name',
                        [
                            'pl' => 'Przewodniczący tracku'
                        ]
                    );

                    break;

                case 'Local chair':
                    $this->translate(
                        'en',
                        $role,
                        (new Role()),
                        'name',
                        [
                            'pl' => 'Przewodniczący lokalny'
                        ]
                    );

                    break;

                default:
                    $this->translate(
                        'en',
                        $role,
                        (new Role()),
                        'name'
                    );
            }
        }
    }
}
