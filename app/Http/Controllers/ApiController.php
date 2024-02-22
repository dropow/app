<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    //レストラン検索メソッド
    public function searchRestaurants(Request $request)
    {
        $apiKey = env('HOTPEPPER_API_KEY');
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $range = $request->range;
        $genre = $request->genre;
        $budget = $request->budget;
        $count = $request->count ? $request->count : 100; // 取得するデータの件数

        $response = Http::get('https://webservice.recruit.co.jp/hotpepper/gourmet/v1/', [
            'key' => $apiKey,
            'lat' => $latitude,
            'lng' => $longitude,
            'range' => $range,
            'genre' => $genre,
            'budget' => $budget,
            'count' => $count,
            'format' => 'json'
        ]);

        return $response->json();
    }

    // 店舗の詳細情報を取得するメソッド
    public function getRestaurantDetails($id)
    {
        $apiKey = env('HOTPEPPER_API_KEY');

        $response = Http::get('https://webservice.recruit.co.jp/hotpepper/gourmet/v1/', [
            'key' => $apiKey,
            'id' => $id,
            'format' => 'json'
        ]);

        return $response->json();
    }
    public function fetchGenres()
    {
        $apiKey = env('HOTPEPPER_API_KEY');
        $response = Http::get('http://webservice.recruit.co.jp/hotpepper/genre/v1/', [
            'key' => $apiKey,
            'format' => 'json'
        ]);

        return $response->json();
    }
    public function fetchBudgets()
    {
        $apiKey = env('HOTPEPPER_API_KEY');
        $response = Http::get('http://webservice.recruit.co.jp/hotpepper/budget/v1/', [
            'key' => $apiKey,
            'format' => 'json'
        ]);

        return $response->json();
    }
}