<?php

namespace App\Http\Controllers\campaign;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Http\Requests\campaign\CampaignStoreRequest;
use App\Models\Campaign;
use App\Traits\CampaignStoreTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends DefaultController
{
    use CampaignStoreTrait;
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['records'] = Campaign::where('id', '!=', null)->get();
            return view('themes.default.pages.campaign.index', $this->data);
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

    public function create() {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            return view('themes.default.pages.campaign.create', $this->data);
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

    public function store(CampaignStoreRequest $request) {
        try {
            $request->request->add([
               'slug' => Str::slug($request->get('title')),
               'url_slug' => Str::slug($request->get('title'))
            ]);
            //Add record
            $record                         =           $this->save($request, true);
            //Flash success
            session()->flash('success_message','New record successfully created!');
            return redirect()->route('campaign.index');
        } catch (\Exception $e) {
            dd($e);
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
