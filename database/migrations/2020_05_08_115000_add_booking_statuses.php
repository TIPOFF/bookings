<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Tipoff\Statuses\Models\Status;

class AddBookingStatuses extends Migration
{
    public function up()
    {
        Status::publishStatuses('booking', [
            'Pending',
            'Cancelled',
            'Confirmed',
        ]);
    }
}
