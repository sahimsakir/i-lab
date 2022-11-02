<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ideas', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 20)->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_piloted')->default(false);
            $table->timestamp('featured_at')->nullable();
            $table->boolean('is_read')->default(true);
            $table->string('topic', 60);
            $table->string('title', 100);
            $table->string('elevator_pitch', 1536);
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
}
