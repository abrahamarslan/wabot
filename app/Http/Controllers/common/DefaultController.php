<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class DefaultController extends Controller
{
    protected $result;
    protected $messageBag = null;
    public function __construct()
    {
        $this->messageBag = new MessageBag();
    }
}
