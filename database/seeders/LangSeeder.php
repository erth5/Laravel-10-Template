<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $german = new Lang;
        $german->setTranslations('language', ['de' => 'deutsch', 'en' => 'german', 'fr' => 'allemand']);
        $german->abbreviation = 'de';
        $german->save();

        $english = new Lang;
        $english->setTranslations('language', ['de' => 'englisch', 'en' => 'english', 'fr' => 'anglais']);
        $english->abbreviation = 'en';
        $english->save();

        $english = new Lang;
        $english->setTranslations('language', ['de' => 'französisch', 'en' => 'french', 'fr' => 'français']);
        $english->abbreviation = 'fr';
        $english->save();

        /** country based data:
        Lang::factory()->create([
            'language' => 'english (UK)',
            'abbreviation' => 'en',
            'country_code' => 'US, USA (ISO 3166-1)',
            'flag' => 'https://flagpedia.net/data/flags/w1160/us.webp'
            'country_code' => 'en-GB
        ]);
         */
    }
}
