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
            $table->foreignIdFor(app('user'));
            $table->morphs('order'); // Can this be $table->foreignIdFor(app('order'));
            $table->integer('total_participants');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('total_taxes');
            $table->unsignedInteger('total_fees');
            $table->morphs('experience');
            $table->morphs('subject');
            $table->foreignIdFor(Rate::class);
            $table->foreignIdFor(BookingCategory::class);
            $table->morphs('agent');
            $table->datetime('proccessed_at');
            $table->datetime('canceled_at');

            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->timestamps();
        });
    }
}
