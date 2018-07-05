<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    public function index() {
        $client = new Client();
        $res = $client->request('GET', 'https://cards.davidneal.io/api/cards');
        $cards = json_decode((string) $res->getBody(), true);
        shuffle($cards);
        session(['cards'=> $cards]);
        return view('cards');
    }

    public function getCard(Request $request) {
        $cards = session('cards');
        $card = array_shift($cards);
        shuffle($cards);
        session(['cards'=> $cards]);
        return Response::json($card);
    }
}
