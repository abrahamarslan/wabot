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
            //return redirect()->route('dashboard.index');
        }
        return view('themes.default.pages.authentication.index');
    }

    /**
     * Get user login
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */

    public function create(Request $request) {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ],
            [
                'email' => __('authentication/validation.login.email_required'),
                'password' => __('authentication/validation.login.password_required')
            ]);

        try {
            $data = ['login' => $request->get('email'), 'password' => $request->get('password')];
            //Log in the user
            if ($user = Sentinel::authenticate($data, $request->get('remember-me', false))) {
                //if($user->inRole('users') OR $user->inRole('instructor'))
                if($user->inRole('users'))
                {
                    //Add log of new login
                    activity()
                        ->performedOn($user)
                        ->causedBy($user)
                        ->withProperties([
                            'type'                  =>         'Notification',
                            'action'                =>         'postLogin',
                            'class'                 =>         'AuthenticationController',
                            'description'           =>         __('authentication/log.login.log_message'),
                            'user_id'               =>          $user->id
                        ])
                        ->log(__('authentication/log.login.action'));
                    //Flash login success message
                    Alert::success(__('authentication/messages.success.login'));
                    return redirect()->route('dashboard.index');
                } else {
                    Sentinel::logout();
                    session()->flash('success_message','Unauthorized Access');
                    return redirect()->route('authentication.login.index')->withInput()->withErrors($this->messageBag);
                }

            }
            //The user is not found
            $this->messageBag->add('user', __('authentication/messages.account_not_found'));
        }
        catch (NotActivatedException $e) {
            $this->messageBag->add('email', __('authentication/messages.account_not_activated'));
        }
        catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->messageBag->add('email', __('authentication/messages.account_suspended', compact('delay' )));
        }
        catch (\Exception $e) {
            $this->messageBag->add('email', $e->getMessage());
        }
        // Ooops.. something went wrong
        return redirect()->route('authentication.login.index')->withInput()->withErrors($this->messageBag);
    }

    public function getLogout() {
        try {
            if($user = Sentinel::check()) {
                \GeneralHelper::markOnlineStatus($user->id, 'Offline');
            }
            // Log the user out
            Sentinel::logout();
            // Redirect to the login page
            session()->flash('success_message',__('authentication/messages.success.logout'));
            return redirect()->route('authentication.login.index');
        } catch (NotActivatedException $e)
        {
            // Redirect to the login page
            $this->messageBag->add('error', __('authentication/messages.account_not_activated'));
            return redirect()->route('authentication.login.index');
        } catch (\Exception $e)
        {
            // Redirect to the login page
            $this->messageBag->add('error', __('authentication/messages.generic_error'));
            return redirect()->route('authentication.login.index');
        }

    }
}
