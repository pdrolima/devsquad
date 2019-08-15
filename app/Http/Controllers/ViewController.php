<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('layouts.app');
    }

}
