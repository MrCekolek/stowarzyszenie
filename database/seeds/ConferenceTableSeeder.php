<?php

use App\Models\Conference;
use Illuminate\Database\Seeder;

class ConferenceTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Conference::class)->create([
            'status' => 'during',
            'translation_key' => Conference::statuses()['during'],
            'name_pl' => 'Przykładowa konferencja',
            'name_en' => 'Example conference',
            'name_ru' => 'Пример конференции',
            'content_pl' => '',
            'content_en' => '',
            'content_ru' => ''
        ]);
    }
}
