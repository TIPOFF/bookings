<?php

namespace Tipoff\Bookings\Http\Controllers;

use Tipoff\Bookings\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreContactDetails;
use App\Models\Location;
use App\Transformers\UserTransformer;
use Facades\App\UseCases\CreateBookingUser;

class ContactDetailsController extends Controller
{
    public function store(Location $location, StoreContactDetails $request)
    {
        $user = CreateBookingUser::updateOrCreateUser($request->validated())
            ->addUserLocation($location)
            ->user();

        return fractal($user, new UserTransformer)
            ->respond();
    }
}
