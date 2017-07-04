<?php

/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:39
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', ['o' => 'index']);
    }
}