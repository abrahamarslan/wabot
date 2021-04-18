<?php

namespace App\Http\Controllers\sequence;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Conditional;
use App\Models\Sequence;
use App\Traits\SequenceStoreTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ConditionalController extends DefaultController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getConditionals (Campaign $campaign) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['create'] = true;
            $this->data['record'] = $campaign;
            $this->data['records'] = $campaign->sequences()->orderBy('order','ASC')->get();
            $sequences = $campaign->sequences()->orderBy('order','ASC')->pluck('title','id');
            $sequences->prepend('No Action', '-1');
            $this->data['sequences'] = $sequences;
            return view('themes.default.pages.sequence.conditionals', $this->data);
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

    public function postConditionalOptions(Request $request) {
        try {
            $optArray = array();
            $sequenceID = $request->get('sequenceID');
            if($sequenceID) {
                $i = 0;
                $sequence = Sequence::findOrFail($sequenceID);
                foreach ($sequence->options as $option) {
                    if(is_null($option["options"]) or empty($option["options"])) {
                        continue;
                    }
                    array_push($optArray, ['key' => $i, 'value' => $option["options"]]);
                    $i++;
                }
                $data = [
                    'type' => 'success',
                    'message' => 'Record updated successfully.',
                    'data' => $optArray,
                    'code' => 200
                ];
                return response()->json($data,200);
            }
            $data = [
                'type' => 'error',
                'message' => 'Some error occurred in getting the records.',
                'data' => null,
                'code' => 500
            ];
            return response()->json($data,500);
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
                'message' => 'Some error occurred in getting the records.',
                'data' => null,
                'code' => 500
            ];
            return response()->json($data,500);
        }
    }

    // Save Conditional for a sequence of a campaign
    public function postAddConditional(Request $request) {
        try {
            $conditional = null;
            $data = $request->all();
            $exists = Conditional::where('campaign_id', $data['campaign_id'])->where('sequence_id', $data['sequence_id'])->first();
            if(!$exists) {
                $conditional = new Conditional($data);
            } else {
                $conditional = $exists;
            }
            //$campaign = Campaign::findOrFail($data['campaign_id']);
            $conditional->hasCondition = ($data['hasCondition'] == 'true' ? 1 : 0);
            $conditional->save();
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
                ->withProperties([
                    'content_id' => 0, // Exception
                    'contentType' => 'Exception',
                    'action' => 'index',
                    'description' => 'DefaultController',
                    'details' => 'Error in creating view: ' . $e->getMessage(),
                    'data' => json_encode($e)
                ])
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
