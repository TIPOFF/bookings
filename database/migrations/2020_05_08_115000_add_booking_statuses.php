<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Tipoff\Statuses\Models\Status;

class AddBookingStatuses extends Migration
{
    public function up()
    {
        foreach([
                [
                    'slug'          => 'bookings-pending',
                    'name'          => 'Pending Booking',
                    'applies_to'    => 'booking'
                ],
                [
                    'slug'          => 'bookings-cancelled',
                    'name'          => 'Pending Cancelled',
                    'applies_to'    => 'booking'
                ],
                [
                    'slug'          => 'bookings-confirmed',
                    'name'          => 'Pending Confirmed',
                    'applies_to'    => 'booking'
                ]
            ] as $status) {
            Status::findOrCreate($status);
        }
    }
}
