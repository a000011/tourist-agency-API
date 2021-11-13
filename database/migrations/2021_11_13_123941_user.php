<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'Users',
            function (Blueprint $table) {
                $table->id();
                $table->string('role');
                $table->string('login');
                $table->string('password');
                $table->string('firstname');
                $table->string('lastname');
                $table->string('avatar');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
