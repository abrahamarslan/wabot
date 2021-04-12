<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ActivationController extends DefaultController
{
    public function getActivateUser(User $user, $code) {
        if(\ActivationHelper::completeActivation($user->id,$code)) {
            session()->flash('success_message','Activation complete');
            return redirect()->route('authentication.login.index');
        } else {
            $this->messageBag->add('email', __('Wrong activation code.'));
            return redirect()->route('authentication.login.index')->withInput()->withErrors($this->messageBag);
        }
    }

    public function getCreateActivation(User $user) {
        if(\ActivationHelper::createActivation($user->id)) {
            dd('Activation created');
        }
    }
}
