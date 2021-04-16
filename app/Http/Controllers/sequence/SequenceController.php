<?php

namespace App\Http\Controllers\sequence;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Http\Requests\sequence\SequenceStoreRequest;
use App\Models\Campaign;
use App\Models\Sequence;
use App\Traits\SequenceStoreTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SequenceController extends DefaultController
{
    use SequenceStoreTrait;
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Campaign $campaign) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['records'] = $campaign->sequences()->orderBy('order','ASC')->get();
            return view('themes.default.pages.sequence.index', $this->data);
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

    public function update(Request $request, Sequence $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['campaigns'] = Campaign::where('status','=','Active')->orderBy('created_at','DESC')->pluck('title','id');
            if(empty($this->data['campaigns'])) {
                return redirect()->back()->withInput()->withErrors(['error_msg' => 'You must create a campaign first']);
            }
            $this->data['record'] = $id;
            $this->data['create'] = false;
            return view('themes.default.pages.sequence.create', $this->data);
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
            $this->data['campaigns'] = Campaign::where('status','=','Active')->orderBy('created_at','DESC')->pluck('title','id');
            if(empty($this->data['campaigns'])) {
                return redirect()->back()->withInput()->withErrors(['error_msg' => 'You must create a campaign first']);
            }
            $this->data['create'] = true;
            return view('themes.default.pages.sequence.create', $this->data);
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

    public function store(SequenceStoreRequest $request) {
        try {
            //Add record
            $record                         =           $this->save($request, true);
            //Flash success
            session()->flash('success_message','New record successfully created!');
            return redirect()->route('sequence.index', $request->get('campaign_id'));
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

    public function postUpdate(SequenceStoreRequest $request, Sequence $id) {
        try {
            //Add record
            $record                         =           $this->save($request, false, $id);
            //Flash success
            session()->flash('success_message','Record updated successfully!');
            return redirect()->route('sequence.index', $request->get('campaign_id'));
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

    public function delete(Request $request, Sequence $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $id->delete();
            session()->flash('success_message','Record deleted successfully!');
            return redirect()->route('campaign.index');
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

    public function getSort(Campaign $campaign) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['record'] = $campaign;
            if(!$campaign->sequences()->count() > 0) {
                return redirect()->back()->withInput()->withErrors(['error_msg' => 'You must create sequence for this campaign first']);
            }
            $this->data['sequences'] = $campaign->sequences()->orderBy('order','ASC')->get();
            $this->data['create'] = true;
            return view('themes.default.pages.sequence.sort', $this->data);
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

    public function postSort(Request $request) {
        try {
            $data = $request->all();
            $order = 1;
            foreach ($data as $row) {
                $record = Sequence::findOrFail($row['id']);
                $record->order = $order;
                $record->save();
                $order++;
            }
            $this->data['create'] = true;
            $data = [
                'type' => 'success',
                'message' => 'Record updated successfully.',
                'data' => [],
                'code' => 200
            ];
            return response()->json($data,200);
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
            $data = [
                'type' => 'error',
                'message' => 'Some error occurred in creating the record.',
                'data' => null,
                'code' => 500
            ];
            return response()->json($data,500);
        }
    }
}
