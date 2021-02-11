<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('order'));
            $table->foreignIdFor(app('slot'));
            $table->unsignedTinyInteger('participants');
            $table->boolean('is_private')->default(false);
            $table->unsignedInteger('amount'); // Amount is in cents. It is net, excluding taxes and fees. An accessor for total_amount adds the 3 columns
            $table->unsignedInteger('total_taxes'); // Taxes is in cents. Computed from attached tax.
            $table->unsignedInteger('total_fees'); // Processing Fees is in cents. Computed from attached fee.
            $table->foreignIdFor(app('rate'))->nullable(); // Pricing rate structure used on this booking
            $table->foreignIdFor(app('tax'))->nullable(); // Tax rate used on this booking
            $table->foreignIdFor(app('fee'))->nullable(); // Processing fee used on this booking
            $table->timestamps();
        });
    }
}
