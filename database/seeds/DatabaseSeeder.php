<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(PermissionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PortfolioTabsSeeder::class);
        $this->call(HomeNavigationSeeder::class);
        // $this->call(ConferenceTableSeeder::class);
    }
}
