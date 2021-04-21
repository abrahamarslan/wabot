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
            self::startCampaign($campaign->id);
            //$result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            //dd($result);
        } catch (\Exception $e) {
            dd($e);
            abort(500);
        }
    }

    public function startCampaign($campaignID) {
        try {

        } catch (\Exception $e) {
            dd($e);
            abort(500);
        }
    }


}
