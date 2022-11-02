<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 20)->unique();
            $table->boolean('is_active')->default(false);
            $table->string('staff_id', 60)->unique();
            $table->string('first_name', 60)->nullable();
            $table->string('last_name', 60)->nullable();
            $table->string('email', 120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cell_number', 20)->nullable();
            $table->string('designation', 120)->nullable();
            $table->string('team', 60)->nullable();
            $table->string('profile_picture')->nullable();
            $table->boolean('tnc_accepted')->default(false);
            $table->timestamp('tnc_accepted_at')->nullable();
            $table->string('password');
            $table->string('two_factor_auth_token', 10)->nullable();
            $table->timestamp('two_factor_auth_expiry')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
