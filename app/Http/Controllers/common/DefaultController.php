<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class DefaultController extends Controller
{
    protected $result;
    protected $messageBag = null;
    protected $data;
    public function __construct()
    {
        $this->data = array();
        $this->messageBag = new MessageBag();
        $this->middleware('App\Http\Middleware\authentication\Authentication');

    }
}
