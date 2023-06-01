<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
        ])->post('https://api.openai.com/v1/chat/completions', [
            "model" => $request->post('model'),
            "messages" => [
                [
                    "role" => "user",
                    "content" => $request->post('content')
                ]
            ],
            "temperature" => 0,
            "max_tokens" => 2048
        ])->body();

        return response()->json(json_decode($response));
    }
}
