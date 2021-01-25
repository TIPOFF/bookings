<?php

namespace Tipoff\Bookings;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Bookings\Bookings
 */
class BookingsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookings';
    }
}
