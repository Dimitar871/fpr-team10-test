<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QuoteService
{
        public function getDailyQuote()
    {
        $url = 'https://zenquotes.io/api/today';
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json()[0];
        }

        return [
            'q' => 'No current quote available.', //quote
            'a' => 'ZenQuotes API Error' //author
        ];
    }
}
