<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingStatusTable extends Migration
{
    public function up()
    {
        Schema::create('booking_status', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });
    }
}
