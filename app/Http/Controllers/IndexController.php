<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('index');
    }

    public function send(Request $request)
    {
        $client = \OpenAI::client(config('chat.key'));

        $result = $client->completions()->create([
            'model'  => 'text-davinci-003',
            'prompt' => $request->get('message'),
        ]);

        return response()->json([
            'send'    => view('send', ['message' => $request->get('message')])->render(),
            'receive' => view('receive', ['message' => $result['choices'][0]['text']])->render(),
        ]);
    }
}
