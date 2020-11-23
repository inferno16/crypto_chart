<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceResource;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $prices = Price::getByCurrencies($request->post('from'), $request->post('to'))
            ->where('timestamp', '>=', Carbon::now()->subHour(24)->format('Y-m-d H:i:s'))
            ->get();

        return PriceResource::collection($prices);
    }
}
