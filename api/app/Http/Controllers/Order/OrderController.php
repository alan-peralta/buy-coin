<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int)$request->input('per_page') ?: 20;
        $page = (int)$request->input('page') ?: 1;

        $query = Order::query()
            ->with(['status', 'quote', 'user'])
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC');

        $query->when($request->filled('status_id'), fn($query) => $query->where('status_id', $request->input('status_id')));


        return response()->json($query->paginate($perPage, ['*'], 'page', $page));
    }
}
