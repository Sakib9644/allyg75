<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('story_descrips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('my_stories_id')->constrained('my_stories')->onDelete('cascade');
            $table->longText("description");
            $table->string("cover_image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_descrips');
    }
};
