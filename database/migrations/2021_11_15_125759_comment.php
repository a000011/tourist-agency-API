<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'Comments',
            function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('tour_id');
                $table->integer('mark');
                $table->string('content');
                $table->dateTime('updated_at');
                $table->dateTime('created_at');
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
