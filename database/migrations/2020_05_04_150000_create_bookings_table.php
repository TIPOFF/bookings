<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\BookingStatus;
use Tipoff\Bookings\Models\Rate;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('slot_number');
            $table->integer('total_participants');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('total_taxes');
            $table->unsignedInteger('total_fees');
            $table->morphs(app('experience'));
            $table->morphs(app('order'));
            $table->foreignIdFor(Rate::class);
            $table->foreignIdFor(BookingCategory::class);
            $table->unsignedBigInteger('booking_status_id');
            $table->foreign('booking_status_id')->references('id')->on('booking_status');
            $table->morphs(app('agent'));
            $table->morphs(app('user'));
            $table->morphs(app('subject'));
            $table->datetime('proccessed_at');
            $table->datetime('canceled_at');
            $table->timestamps();
        });
    }
}
