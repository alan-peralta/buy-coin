<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinalizeOrderRequest;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FinalizeOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FinalizeOrderRequest $request): JsonResponse
    {
        /** @var Order $order */
        $order = Order::query()->find($request->input('order_id'));
        DB::transaction(function () use ($request, &$order) {
            if ($request->input('status_id') == Status::APPROVED) {
                $order->status_id = Status::APPROVED;
            } elseif ($request->input('status_id') == Status::CANCELLED) {
                $order->status_id = Status::CANCELLED;
            }
            $order->save();
        }, 2);

        return response()->json($order->refresh());
    }
}
