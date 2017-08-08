<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function show($id)
    {
        $base_url = 'http://saxcy.info';
        $client = new \GuzzleHttp\Client( [
            'base_uri' => $base_url,
        ] );
        $path = '/dale_api/bad_moves/' . $id;
        $response = $client->request( 'GET', $path,
        [
           'allow_redirects' => true,
        ] );
        $response_body = (string) $response->getBody();

        $res_json = json_decode($response_body, true)[0];
        $kif_id = $res_json['kif_id'];
        $move_num = $res_json['move_num'];

        $to_escape_arr = [' ', '/', '+'];
        $escaped_arr = ['%20', '%2F', '%2B'];
        $sfen = str_replace($to_escape_arr, $escaped_arr, $res_json['sfen']);
        $board_url = 'http://sfenreader.appspot.com/sfen?sfen=' . $sfen;

        if ( $move_num % 2 == 0)
        {
            $turn = '後手番(奥)';
        }
        else
        {
            $turn = '先手番(手前)';
        }

        return view('show', [
            'kif_id' => $kif_id,
            'move_num' => $move_num,
            'board_url' => $board_url,
            'turn' => $turn,
            'sfen' => $res_json['sfen']
        ]);
    }
}
