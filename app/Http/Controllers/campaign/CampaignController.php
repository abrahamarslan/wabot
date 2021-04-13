<?php

namespace App\Http\Controllers\campaign;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignController extends DefaultController
{
    public function index() {
        try {
            return view('themes.default.pages.campaign.index');
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            activity()
                ->by('CampaignController')
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
