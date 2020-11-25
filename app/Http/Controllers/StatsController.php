<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceResource;
use App\Models\Price;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $prices = Price::getByCurrencies($request->post('from'), $request->post('to'))->get();

        return PriceResource::collection($prices);
    }
}
