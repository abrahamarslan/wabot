<?php

namespace App\Http\Controllers\campaign;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Http\Requests\campaign\CampaignContactStoreRequest;
use App\Imports\ContactsImport;
use App\Models\Campaign;
use App\Models\Contact;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CampaignContactController extends DefaultController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getImport(Request $request, Campaign $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['record'] = $id;
            $this->data['create'] = true;
            return view('themes.default.pages.campaign.import.import', $this->data);
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            activity()
                ->by('CampaignContactController')
                ->withProperties([
                    'content_id' => 0, // Exception
                    'contentType' => 'Exception',
                    'action' => 'index',
                    'description' => 'CampaignContactController',
                    'details' => 'Error in creating view: ' . $e->getMessage(),
                    'data' => json_encode($e)
                ])
                ->causedBy('index')
                ->log($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function postImport(CampaignContactStoreRequest $request, Campaign $id) {
        try {
            $data = Excel::toCollection(new ContactsImport(), request()->file('file'));
            if($data->count() > 0) {
                $rows = $data->all();
                if(isset($rows[0]))
                {
                    foreach ($rows[0] as $row) {
                        $record = new Contact($row->toArray());
                        $record->campaign_id = $id->id;
                        $record->registered_at = date('Y-m-d H:i:s');
                        $record->save();
                    }
                    session()->flash('success_message','Records successfully imported to the campaign!');
                }
            }
            return redirect()->back()->withInput()->withErrors(['error_msg' => 'No data to import']);
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

    public function getContacts(Campaign $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['record'] = $id;
            $this->data['records'] = $id->contacts()->orderBy('created_at','DESC')->get();
            return view('themes.default.pages.campaign.import.view', $this->data);
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

    public function delete(Request $request, Contact $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $id->delete();
            session()->flash('success_message','Record deleted successfully!');
            return redirect()->back();
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

    public function getResults(Request $request, Contact $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['record'] = $id;
            $this->data['create'] = true;
            return view('themes.default.pages.campaign.import.history', $this->data);
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            activity()
                ->by('CampaignContactController')
                ->withProperties([
                    'content_id' => 0, // Exception
                    'contentType' => 'Exception',
                    'action' => 'index',
                    'description' => 'CampaignContactController',
                    'details' => 'Error in creating view: ' . $e->getMessage(),
                    'data' => json_encode($e)
                ])
                ->causedBy('index')
                ->log($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }
}
