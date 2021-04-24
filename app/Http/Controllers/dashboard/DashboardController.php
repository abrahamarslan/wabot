<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class DashboardController extends DefaultController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Dashboard
     */
    public function index() {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
                $todayDate = Carbon::today();
                $this->data['sent_today'] = Message::where('created_at', '>=', $todayDate)->where('direction','send')->count();
                $this->data['received_today'] = Message::where('created_at', '>=', $todayDate)->where('direction','received')->count();
                $this->data['campaigns'] = Campaign::all()->count();
                $this->data['users'] = User::all()->count();
                return view('themes.default.pages.dashboard.index', $this->data);
            }
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            dd($e);
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }
}
