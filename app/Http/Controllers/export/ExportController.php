<?php

namespace App\Http\Controllers\export;

use App\Exports\MessagesExport;
use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends DefaultController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index() {
        try {
            if($user = Sentinel::check()) {
                $this->data['create'] = true;
                $this->data['user'] = $user;
                $this->data['campaigns'] = Campaign::where('status', 'Active')->pluck('title', 'id');
                return view('themes.default.pages.export.index', $this->data);
            }
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request) {
        try {
            if($user = Sentinel::check()) {
                $this->data['create'] = true;
                $this->data['user'] = $user;
                $campaignID = $request->get('campaign_id');
                $campaign = Campaign::findOrFail($campaignID);
                return Excel::download(new MessagesExport, $campaign->title .'_results.xlsx');
            }
        } catch (\Exception $e) {
            dd($e);
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }
}
