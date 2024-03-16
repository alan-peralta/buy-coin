<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinalizeOrderRequest;
use App\Models\Order;
use App\Models\Status;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FinalizeOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FinalizeOrderRequest $request): JsonResponse
    {
        /** @var Order $order */
        $order = Order::query()->find($request->input('order_id'));

        if (in_array($order->status_id, Status::FINALIZE_ORDER)) {
            return response()->json([
                "error" => [
                    "message" => "Ordem já está finalizada"
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::transaction(function () use ($request, &$order) {
            if ($request->input('status_id') == Status::APPROVED) {
                $order->status_id = Status::APPROVED;
            } elseif ($request->input('status_id') == Status::CANCELLED) {
                $order->status_id = Status::CANCELLED;
            }
            $order->save();
        }, 2);

        return response()->json("Compra realizada com sucesso");
    }
}
