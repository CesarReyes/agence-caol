<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class Comercial extends Controller
{
    /**
     * Show the performance view
     */
    public function performance()
    {
        return view('comercial.performance');
    }
}