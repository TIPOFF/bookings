<?php

namespace Tipoff\Bookings\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Facades\App\UseCases\PurchaseBooking;
use Tipoff\Bookings\Http\Requests\MakePurchase;

class CheckoutController extends Controller
{
    public function store(Location $location, MakePurchase $request)
    {
        $user = User::find($request->user_id);

        PurchaseBooking::handle($location, $user, $request->validated());

        return response()->json(null, 200);
    }
}
