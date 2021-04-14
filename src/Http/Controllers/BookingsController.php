<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Http\Controllers;

use Illuminate\Http\Request;
use Tipoff\Locations\Models\Location;
use Tipoff\Locations\Models\Market;
use Tipoff\Support\Http\Controllers\BaseController;

class BookingsController extends BaseController
{
    public function __invoke(Request $request, Market $market, Location $location)
    {
        return view('bookings::bookings')->with([
            'market' => $market,
            'location' => $location,
        ]);
    }
}
