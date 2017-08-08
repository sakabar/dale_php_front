<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function show($id)
    {
        return view('show', ['name' => 'Jhonson', 'id' => $id]);
    }
}
