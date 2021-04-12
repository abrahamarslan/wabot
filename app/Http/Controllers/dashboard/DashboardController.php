<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends DefaultController
{
    /**
     * Dashboard
     */
    public function index() {
        try {
            return view('themes.default.pages.dashboard.index');
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            activity()
                ->by('DashboardController')
                ->withProperties([
                    'content_id' => 0, // Exception
                    'contentType' => 'Exception',
                    'action' => 'index',
                    'description' => 'DefaultController',
                    'details' => 'Error in creating view: ' . $e->getMessage(),
                    'data' => json_encode($e)
                ])
                ->causedBy('index')
                ->log($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }
}
