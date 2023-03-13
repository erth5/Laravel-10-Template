<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Resource_Image_Routes.png';
        // Default Demo User
        Image::factory()->create([
            'path' => '',
            'name' => $name,
            'extension' => 'png',
            'person_id' => Person::where('username', 'laraveller')->first(),
            'user_id' => User::where('email', 'fdsdwp@protonmail.com')->first(),
            'upload_time' => now(),
            'update_time' => now(),
            'remove_time' => null,
        ]);
        $src = database_path('seeders\\') . $name;
        $dest = storage_path('app\public\\') . $name;
        if (file_exists($src)) {
            File::copy($src, $dest);
            Log::debug('seeding: image ' . $name . 'successful copied');
        } else
            echo ('seeding: Example Image not found');
    }
}
