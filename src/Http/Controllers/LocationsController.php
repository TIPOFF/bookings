<?php

namespace Tipoff\Bookings\Http\Controllers;

use Tipoff\Bookings\Http\Controllers\Controller;
use App\Models\Location;
use App\Transformers\LocationTransformer;

class LocationsController extends Controller
{
    public function show(Location $location)
    {
        return fractal($location, new LocationTransformer)
            ->respond();
    }
}
