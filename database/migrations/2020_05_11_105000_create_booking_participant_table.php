<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingParticipantTable extends Migration
{
    public function up()
    {
        Schema::create('booking_participant', function (Blueprint $table) {
            $table->foreignIdFor(app('booking'))->index();
            $table->foreignIdFor(app('participant'))->index();
            $table->timestamps();
        });
    }
}
