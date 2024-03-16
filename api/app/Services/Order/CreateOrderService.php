<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Status;

class CreateOrderService
{
    public function execute($request, $quote, $tax): Order
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->amount = $request->input('amount');
        $order->amount_decimals = config('services.money.decimals');
        $order->amount_converted = (int)(($request->input('amount') / $quote->bid) * config('services.money.percent_multiplier'));
        $order->amount_converted_decimals = config('services.money.decimals');
        $order->tax = $tax;
        $order->quote_id = $quote->id;
        $order->status_id = Status::NEW;
        $order->save();

        return $order;

    }
}
