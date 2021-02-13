<?php

namespace Tipoff\Bookings\Http\Controllers;

use App\Models\User;
use App\Models\Voucher;
use App\Transformers\CartTransformer;
use Tipoff\Bookings\Http\Requests\StoreVoucherApplication;

class VoucherApplicationsController extends Controller
{
    public function store(User $user, StoreVoucherApplication $request)
    {
        $voucher = Voucher::where('code', $request->code)->first();

        $user->cart()->applyVoucher($voucher);

        return fractal($user->cart(), new CartTransformer)
            ->respond();
    }
}
