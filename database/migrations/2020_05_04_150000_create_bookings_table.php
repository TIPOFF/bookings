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
            $table->string('slot_number');
            $table->foreignIdFor(app('user'));
            $table->foreignIdFor(app('location'));
            $table->integer('total_participants');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('total_taxes');
            $table->unsignedInteger('total_fees');
            $table->morphs('experience');
            $table->morphs('subject');
            $table->foreignIdFor(app('rate'));
            $table->foreignIdFor(app('booking_category'));
            $table->morphs('agent');
            $table->datetime('processed_at');
            $table->datetime('canceled_at');

            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->timestamps();
        });
    }
}
