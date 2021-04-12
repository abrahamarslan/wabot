<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser;
class User extends EloquentUser
{
    use Notifiable;
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'username',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'permissions',
        'last_login',
        'device_id',
        'image',
        'thumbnail',
        'contact',
        'gender',
        'status',
        'role_id',
        'street_address',
        'landmark',
        'city',
        'state',
        'postal_code',
        'country',
        'current_location',
        'city_geonameId',
        'state_geonameId',
        'country_geonameId',
        'postalcode_geonameId',
        'geocode',
        'city_lat',
        'city_ln',
        'state_lat',
        'state_ln',
        'country_lat',
        'country_ln',
        'postal_code_lat',
        'postal_code_ln',
        'city_name',
        'state_name',
        'country_name',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $loginNames = ['email', 'username'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'json',
    ];
}
