<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Alerts\Laravel\Facades\Alert;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AuthenticationController extends DefaultController
{
    /**
     * Get the user logine view and redirect to dashboard if already logged in.
     * @return
     */
    public function index() {
        if(Sentinel::check()) {
            Alert::warning('You are already logged in!');
            return redirect()->route('dashboard.index');
        }
        return view('themes.default.pages.authentication.index');
    }
}
