<?php

namespace App\Http\Controllers\message;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Sequence;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class DispatchController extends Controller
{
    protected $data = array();
    public function index(Campaign $campaign) {
        try {
            if($campaign->hasStarted == 'True') {
                session()->flash('success_message','Campaign has already started!');
                return redirect()->route('campaign.index');
            }
            $result = self::startCampaign($campaign->id);
            if($result) {
                $campaign->hasStarted = 'True';
                $campaign->save();
            }
            session()->flash('success_message','Campaign has started successfully!');
            return redirect()->route('campaign.index');
            //$result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            //dd($result);
        } catch (\Exception $e) {
            dd($e);
            abort(500);
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function startCampaign($campaignID) {
        try {
            $campaign = \MessageHelper::startCampaign($campaignID);
            return $campaign;
        } catch (\Exception $e) {
            dd($e);
            abort(500);
        }
    }


}
