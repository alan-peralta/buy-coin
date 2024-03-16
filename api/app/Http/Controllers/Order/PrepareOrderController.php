<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareOrderRequest;
use App\Interfaces\GetQuoteServiceInterface;
use App\Models\Coin;
use App\Services\GetCoinDefaultIdService;
use App\Services\GetCoinDefaultService;
use App\Services\GetTaxAmountService;
use App\Services\Order\CreateOrderService;
use App\Services\Quote\CreateQuoteService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PrepareOrderController extends Controller
{
    public function __invoke(PrepareOrderRequest $request): JsonResponse
    {
        $coinDefault = GetCoinDefaultService::execute();

        $coinDefaultId = GetCoinDefaultIdService::execute();

        $coinFrom = Coin::query()->toBase()->where('id', $request->input('coin_id'))->pluck('acronym')->first();

        $quoteService = app(GetQuoteServiceInterface::class)->execute($coinFrom . "-" . $coinDefault);

        if (!array_key_exists($coinFrom . $coinDefault, $quoteService)) {
            return response()->json([
                'error' => [
                    'message' => 'Não foi possível pegar cotação'
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $quote = (new CreateQuoteService())->execute($quoteService[$coinFrom . $coinDefault]);

        $tax = (new GetTaxAmountService())->execute($request->input('coin_id'), $coinDefaultId, $request->input('amount'));

        $order = (new CreateOrderService())->execute($request, $quote, $tax);

        return response()->json($order);
    }
}
