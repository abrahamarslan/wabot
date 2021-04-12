<?php
/**
 * Language file for user error/success messages
 *
 */

return array(

    'user_exists'                                   => 'User already exists!',
    'user_not_found'                                => 'User [:id] does not exist.',
    'user_login_required'                           => 'The login field is required',
    'user_password_required'                        => 'The password is required.',
    'insufficient_permissions'                      => 'Insufficient Permissions.',
    'banned'                                        => 'banned',
    'suspended'                                     => 'suspended',
    'account_already_exists'                        => 'An account with this email already exists.',
    'account_not_found'                             => 'Username/E-mail or password is incorrect.',
    'account_not_activated'                         => 'This user account is not activated.',
    'account_suspended'                             => 'User account suspended because of too many login attempts. Try again after [:delay] seconds',
    'account_banned'                                => 'This user account is banned.',
    'generic_error'                                 => 'Some error occurred in performing that action!',

    'success' => array(
        'login'     => 'You have successfully logged in.',
        'logout'    => 'You have been successfully logged out.',
        'create'    => 'User was successfully created.',
        'update'    => 'User was successfully updated.',
        'delete'    => 'User was successfully deleted.',
        'ban'       => 'User was successfully banned.',
        'unban'     => 'User was successfully unbanned.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'User was successfully restored.',
        'register'  => 'You have successfully registered.'
    ),

    'error' => array(
        'create'    => 'There was an issue creating the user. Please try again.',
        'update'    => 'There was an issue updating the user. Please try again.',
        'delete'    => 'There was an issue deleting the user. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.'
    ),

    'deleteModal' => array(
        'body'			=> 'Are you sure to delete this user? This operation is irreversible.',
        'cancel'		=> 'Cancel',
        'confirm'		=> 'Delete',
        'title'         => 'Delete User',
    ),

);
