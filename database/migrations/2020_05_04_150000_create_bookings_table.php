<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Models\BookingStatus;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('slot_number');
            $table->tinyInteger('total_participants');
            $table->integer('total_amount');
            $table->integer('amount');
            $table->integer('total_taxes');
            $table->integer('total_fees');
            // Todo: Add morph relation foreign IDs
//            $table->foreignIdFor(app('variation'))->nullable();
//            $table->foreignIdFor(app('experience'))->nullable();
//            $table->foreignIdFor(app('order'))->nullable();
//            $table->foreignIdFor(app('agent'))->nullable();
//            $table->foreignIdFor(app('user'))->nullable();
//            $table->foreignIdFor(app('subject'))->nullable();
            $table->foreignIdFor(BookingCategory::class);
            $table->foreignIdFor(BookingStatus::class);
            $table->timestamps();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
        });
    }
}
