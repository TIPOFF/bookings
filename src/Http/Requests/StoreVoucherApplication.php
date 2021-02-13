<?php

namespace Tipoff\Bookings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreVoucherApplication extends FormRequest
{
    protected $cart;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->cart = $this->user->cart();

        return $this->cart->cartItems->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => [
                'required',
                Rule::exists('vouchers', 'code')
                    ->where(function ($query) {
                        $query->whereNull('redeemed_at')
                            ->whereDate('expires_at', '>', Carbon::now())
                            ->where('amount', '<=', $this->cart->total_amount)
                            ->where('location_id', $this->cart->location_id);
                    }),
            ],
        ];
    }
}
