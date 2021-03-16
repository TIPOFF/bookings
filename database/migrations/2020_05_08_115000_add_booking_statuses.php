<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Tipoff\Bookings\Enums\BookingStatus;
use Tipoff\Statuses\Models\Status;

class AddBookingStatuses extends Migration
{
    public function up()
    {
        Status::publishStatuses(BookingStatus::statusType(), BookingStatus::getValues());
    }
}
