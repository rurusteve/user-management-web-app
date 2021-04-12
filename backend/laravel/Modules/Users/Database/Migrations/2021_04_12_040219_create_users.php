<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('role_id')    -> nullable()  -> onDelete('restrict');
            $table -> string('password');
            $table -> string('first_name');
            $table -> string('last_name');
            $table -> string('username');
            $table -> string('email')         -> nullable()  -> unique();
            $table -> string('phone_number')  -> nullable();
            $table -> timestamp('email_verified_at')->nullable();
            $table -> rememberToken();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}
