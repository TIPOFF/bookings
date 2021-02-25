<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('slot_number')->nullable();
            $table->integer('total_participants')->nullable();
            $table->double('total_amount', 8, 2);
            $table->double('amount', 8, 2)->nullable();
            $table->double('total_taxes', 8, 2)->nullable();
            $table->double('total_fees', 8, 2)->nullable();
            $table->morphs('variation')->nullable();
            $table->morphs('experience')->nullable();
            $table->morphs('order')->nullable();
            $table->unsignedBigInteger('booking_category_id');
            $table->foreign('booking_category_id')->references('id')->on('booking_categories');
            $table->unsignedBigInteger('booking_status_id');
            $table->foreign('booking_status_id')->references('id')->on('booking_status');
            $table->morphs('agent')->nullable();
            $table->morphs('user')->nullable();
            $table->morphs('subject')->nullable();
            $table->timestamps();
            $table->date('proccessed_at')->nullable();;
            $table->date('canceled_at')->nullable();;
        });
    }
}
