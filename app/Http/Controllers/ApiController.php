<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function searchRestaurants(Request $request)
    {
        $apiKey = env('HOTPEPPER_API_KEY');
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $range = $request->range;

        $response = Http::get('https://webservice.recruit.co.jp/hotpepper/gourmet/v1/', [
            'key' => $apiKey,
            'lat' => $latitude,
            'lng' => $longitude,
            'range' => $range,
            'format' => 'json'
        ]);

        return $response->json();
    }
}