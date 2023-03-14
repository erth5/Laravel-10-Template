<?php

namespace Tests\Template\Models;

use Exception;
use Tests\TestCase;
use App\Models\Image;
use DirectoryIterator;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertEquals;

use Illuminate\Foundation\Testing\WithFaker;
use function PHPUnit\Framework\assertFileExists;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageTest extends TestCase
{
    /**
     * proof existence of image folder
     * @group data
     * @return void
     */
    public function test_gives_it_a_image_folder()
    {
        assertTrue(is_dir(storage_path('app\public\images')));
    }

    /**
     * Proof saved Images has Database-Entrys
     * @group data
     * @return void
     */
    public function test_saved_files_has_database_entrys()
    {
        $path = storage_path('app\public\images/');
        foreach (new DirectoryIterator($path) as $file) {
            try {
                if ($file->isDot()) continue;
                $fileName = $file->getFilename();
                assertEquals($fileName, Image::where('name', $fileName)->get()->first()->name);
            } catch (Exception $e) {
                assertTrue($fileName);
            }
        }
        assertTrue(true);
    }

    /**
     * Proof Database-Entrys linked to saved Images
     * @group data
     * @return void
     */
    public function test_database_entrys_has_saved_files()
    {
        $images = Image::all();
        if (count($images) == 0)
            assertTrue(true);
        else {
            foreach ($images as $image) {
                $DbImageName = $image->getAttribute('name');
                $DbImagePath = $image->getAttribute('path');
                assertFileExists(storage_path('app\public/' . $DbImagePath . $DbImageName));
            }
        }
    }
}
