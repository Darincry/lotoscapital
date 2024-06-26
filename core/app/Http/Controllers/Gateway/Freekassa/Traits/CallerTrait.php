<?php

namespace App\Http\Controllers\Gateway\Freekassa\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Gateway\Freekassa\Exceptions\InvalidPaidOrder;
use App\Http\Controllers\Gateway\Freekassa\Exceptions\InvalidSearchOrder;

trait CallerTrait
{
    /**
     * @param Request $request
     * @return mixed
     *
     * @throws InvalidSearchOrder
     */
    public function callSearchOrder(Request $request)
    {
        if (is_null(config('freekassa.searchOrder'))) {
            throw new InvalidSearchOrder();
        }

        return App::call(config('freekassa.searchOrder'), ['order_id' => $request->input('MERCHANT_ORDER_ID')]);
    }

    /**
     * @param Request $request
     * @param $order
     * @return mixed
     * @throws InvalidPaidOrder
     */
    public function callPaidOrder(Request $request, $order)
    {
        if (is_null(config('freekassa.paidOrder'))) {
            throw new InvalidPaidOrder();
        }

        return App::call(config('freekassa.paidOrder'), ['order' => $order]);
    }
}
