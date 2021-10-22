<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     *     • To
    • From
    • Date
    • Subject
    • Message-ID
     * @return void
     */
    public function up()
    {
        Schema::create('email_data', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('from');
            $table->string('email_date')->index('email_date');
            $table->string('subject');
            $table->string('message_id');
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
        Schema::dropIfExists('email_data');
    }
}
