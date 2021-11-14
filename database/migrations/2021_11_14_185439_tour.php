<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'Tour',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description');
                $table->longText('img')->nullable();
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
