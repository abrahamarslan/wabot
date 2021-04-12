<?php

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class ActivationHelper
{
    public static function createActivation($id) {
        try {
            if($user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findById($id)) {
                return \Cartalyst\Sentinel\Laravel\Facades\Activation::create($user);
            }
        }
        catch(Exception $e) {
            //Exception Message log
            activity()
                ->withProperties([
                    'type'                  =>         'Error',
                    'action'                =>         'createActivation',
                    'class'                 =>         'ActivationHelper',
                    'description'           =>         $e->getMessage()
                ])
                ->log(__('authentication/log.activation.action'));
        }
        return false;
    }

    public static function completeActivation($id, $activation_code) {
        try {
            if($user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findById($id)) {
                if (\Cartalyst\Sentinel\Laravel\Facades\Activation::complete($user, $activation_code)) {
                    return true;
                }
            }
        }
        catch(Exception $e) {
            //Exception Message log
            activity()
                ->withProperties([
                    'type'                  =>         'Error',
                    'action'                =>         'completeActivation',
                    'class'                 =>         'ActivationHelper',
                    'description'           =>         $e->getMessage()
                ])
                ->log(__('authentication/log.activation.action'));
        }
        return false;
    }

    public static function generateRemember($email) {
        try {
            $data = array();
            // Get the user password recovery code
            $user = Sentinel::findByCredentials(['email' => $email]);
            if (!$user) {
                return [
                    'data' => null,
                    'code' => 201
                ];
            }
            $activation = Activation::completed($user);
            if(!$activation){
                return [
                    'data' => null,
                    'code' => 202
                ];
            }
            //Remove all expired reminders
            Reminder::removeExpired();
            if(Reminder::exists($user)) {
                $reminder = DB::table('reminders')->where('user_id',$user->id)->first();
                if($reminder) {
                    //Reminder already exists
                    $data['user'] = $user;
                    $data['code'] = $reminder->code;
                    $data['link'] = route('authentication.getReset', ['id' => $user->id, 'code' => $reminder->code]);
                    return [
                        'data' => $data,
                        'code' => 200
                    ];
                }
            } else {
                $reminder = Reminder::create($user);
                $data['user'] = $user;
                $data['code'] = $reminder->code;
                $data['link'] = route('authentication.getReset', ['id' => $user->id, 'code' => $reminder->code]);
                return [
                    'data' => $data,
                    'code' => 200
                ];
            }
        } catch (NotActivatedException $e)
        {
            return [
                'data' => null,
                'code' => 203
            ];
        } catch (\Exception $e)
        {
            return [
                'data' => null,
                'code' => 204
            ];
        }
    }
}
