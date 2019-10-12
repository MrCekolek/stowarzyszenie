<?php

use App\Models\User;
use App\Models\AffiliationUser;
use App\Models\PreferenceUser;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // generowanie admina
        factory(User::class)->create([
            'login_email' => 'admin@admin.pl',
            'password' => 'admin123'
        ])->each(function ($user) {
            factory(PreferenceUser::class)->create([
               'user_id' => $user->id
            ]);

            factory(AffiliationUser::class)->create([
                'user_id' => $user->id
            ]);
        });

        // generowanie reszty uzytkownikow
        for ($i = 0; $i < 50; $i++) {
            factory(User::class)->create([
                'password' => '12345678'
            ])->each(function ($user) {
                factory(PreferenceUser::class)->create([
                    'user_id' => $user->id
                ]);

                factory(AffiliationUser::class)->create([
                    'user_id' => $user->id
                ]);
            });
        }
    }
}
