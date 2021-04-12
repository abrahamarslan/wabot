<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Http\Requests\authentication\registration\RegistrationStoreRequest;
use App\Mail\authentication\registration;
use Cartalyst\Alerts\Laravel\Facades\Alert;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class RegistrationController extends DefaultController
{
    public function index(Request $request) {
        if(Sentinel::check()) {
            Alert::warning('You are already logged in!');
            return redirect()->route('dashboard.index');
        }
        return view('themes.default.pages.authentication.create');
    }

    public function create(RegistrationStoreRequest $request) {
        /**
         * Todo: Get this value from the Settings table
         */
        $defaultRole = 1;
        $notifyUser = true;

        $validated = $request->validated();
        //Try to register a new user
        try {
            if($user = Sentinel::register($validated)) {
                if($role = Sentinel::findRoleById($defaultRole)){
                    $role->users()->attach($user);
                    //Add log
                    activity()
                        ->performedOn($role)
                        ->causedBy($user)
                        ->withProperties([
                            'type'                  =>         'Notification',
                            'action'                =>         'postRegister',
                            'class'                 =>         'AuthenticationController',
                            'description'           =>         __('authentication/log.registration.log_message'),
                            'user_id'               =>          $user->id
                        ])
                        ->log(__('authentication/log.registration.action'));
                    if($notifyUser) {
                        //Todo: Add email here
                        $activation = \ActivationHelper::createActivation($user->id);
                        if($activation) {
                            // Data to be used on the email view
                            $data = array(
                                'user'          => $user,
                                'link' => route('activation.getActivateUser', [$user->id, $activation->code]),
                            );
                            \Mail::to($user->email)->send(new registration($data));
                        }
                        else {
                            dd($activation);
                        }
                    }
                    session()->flash('success_message',__('authentication/messages.success.register'));
                    //Redirect to login page
                    return redirect()->route("authentication.getLogin");
                }
            }
            //Failed to register user
            activity()
                ->withProperties([
                    'type'                  =>         'Error',
                    'action'                =>         'postRegister',
                    'class'                 =>         'AuthenticationController',
                    'description'           =>         __('authentication/log.registration.error_message'),
                ])
                ->log(__('authentication/log.registration.action'));
        }
        catch(\Exception $e) {
            //Exception Message log
            activity()
                ->withProperties([
                    'type'                  =>         'Error',
                    'action'                =>         'postRegister',
                    'class'                 =>         'AuthenticationController',
                    'description'           =>         $e->getMessage()
                ])
                ->log(__('authentication/log.registration.action'));
        }
        $this->messageBag->add('error', __('authentication/log.registration.error_message'));
        return redirect()->route("authentication.getLogin")->withErrors($this->messageBag);
    }
}
