<?php

use App\Models\HomeNavigation;
use Illuminate\Database\Seeder;

class HomeNavigationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(HomeNavigation::class)->create([
            'status' => HomeNavigation::statuses()['published'],
            'name_pl' => 'Logowanie',
            'name_en' => 'Sign In',
            'name_ru' => 'Войти',
            'link' => '/auth/login',
            'content_pl' => '',
            'content_en' => '',
            'content_ru' => '',
            'user_id' => 1
        ]);

        factory(HomeNavigation::class)->create([
            'status' => HomeNavigation::statuses()['published'],
            'name_pl' => 'Zarejestruj się',
            'name_en' => 'Register',
            'name_ru' => 'зарегистрироваться',
            'link' => '/auth/register',
            'content_pl' => '',
            'content_en' => '',
            'content_ru' => '',
            'user_id' => 1
        ]);
    }
}
