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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('balance', 10)->default(0);
            $table->string('card_info', 16)->nullable();
            $table->string('csv', 3)->nullable();
            $table->string('expiration_date', 5)->nullable();
            $table->string('github_id')->unique();
            $table->string('access_token');
            $table->string('avatar_url')->nullable();
            $table->string('github_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
