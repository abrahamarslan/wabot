<?php

namespace App\Http\Controllers\role;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class RoleController extends DefaultController
{
    /**@TODO
     * Create a temporary user role
     */
    public function index() {
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users',
            'permissions' => '{"dashboard.access":true}'
        ]);
        dd('Role created. Do not visit this route again.');
    }
}
