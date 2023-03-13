<?php

use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            /** rel to images
             *  $table->bigInteger('image_id');
             *  foreign...
             */
            $table->string('path')->nullable();
            $table->string('name')->default('imageNameError');
            $table->string('extension')->nullable();

            $table->foreignIdFor(Person::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();

            $table->timestamp('upload_time', 0)->nullable();
            $table->timestamp('update_time', 0)->nullable();
            $table->softDeletes('remove_time')->nullable();
        });

        /** Seed Image */
        $resource_file = storage_path('app\public\Resource_Image_Routes.png');
        if (file_exists($resource_file)) {
            if (!unlink($resource_file)) {
                echo ("$resource_file cannot be deleted due to an error");
            } else {
                Log::debug("$resource_file has been deleted");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('images', function (Blueprint $table) {
            if (Schema::hasColumn('remove_time'))
                $table->dropSoftDeletes();
            if (Schema::hasColumns('images', ['person_id', 'user_id'])) {
                $table->dropColumn('person_id');
                $table->dropColumn('user_id');
            }
        }));
        Schema::dropIfExists('images');
    }
};
