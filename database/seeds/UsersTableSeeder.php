<?php

use App\Models\User;
use App\Models\AffiliationUser;
use App\Models\PreferenceUser;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // generowanie admina
        $user = factory(User::class)->create([
            'first_name' => 'Admin',
            'last_name' => '',
            'login_email' => 'admin@admin.pl',
            'password' => 'admin123'
        ]);

        factory(PreferenceUser::class)->create([
            'user_id' => $user->id
        ]);

        factory(AffiliationUser::class)->create([
            'user_id' => $user->id
        ]);

        // generowanie reszty uzytkownikow
        for ($i = 0; $i < 20; $i++) {
            $user = factory(User::class)->create([
                'password' => '12345678'
            ]);

            factory(PreferenceUser::class)->create([
                'user_id' => $user->id
            ]);

            factory(AffiliationUser::class)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
