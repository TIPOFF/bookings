<?php

namespace Tipoff\Bookings\Commands;

use Illuminate\Console\Command;

class BookingsCommand extends Command
{
    public $signature = 'bookings';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
