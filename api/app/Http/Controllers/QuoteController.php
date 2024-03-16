<?php

namespace App\Http\Controllers;

use App\Interfaces\GetQuoteServiceInterface;
use App\Models\CoinCombination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $coins = CoinCombination::query()->toBase()
            ->where('coin_combinations.is_active', 1)
            ->join('coins as from', 'from_coin_id', 'from.id')
            ->join('coins as to', 'to_coin_id', 'to.id')
            ->pluck(DB::raw("CONCAT(from.acronym, '-', to.acronym) as currency"))
            ->toArray();

        $currency = implode(",", $coins);
        $quote = app(GetQuoteServiceInterface::class)->execute($currency);

        return response()->json($quote);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
