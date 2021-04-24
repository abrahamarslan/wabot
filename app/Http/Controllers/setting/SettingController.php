<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\common\DefaultController;
use App\Http\Controllers\Controller;
use App\Http\Requests\setting\SettingStoreRequest;
use App\Models\Setting;
use App\Traits\SettingStoreTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends DefaultController
{
    use SettingStoreTrait;
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['records'] = Setting::where('id', '!=', null)->orderBy('created_at','DESC')->get();
            return view('themes.default.pages.setting.index', $this->data);
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function create() {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['create'] = true;
            return view('themes.default.pages.setting.create', $this->data);
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function store(SettingStoreRequest $request) {
        try {
            //Add record
            $record                         =           $this->save($request, true);
            //Flash success
            session()->flash('success_message','New record successfully created!');
            return redirect()->route('setting.index');
        } catch (\Exception $e) {
            dd($e);
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Setting $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $this->data['record'] = $id;
            $this->data['create'] = false;
            return view('themes.default.pages.setting.create', $this->data);
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function postUpdate(SettingStoreRequest $request, Setting $id) {
        try {
            //Add record
            $record                         =           $this->save($request, false, $id);
            //Flash success
            session()->flash('success_message','Record updated successfully!');
            return redirect()->route('setting.index');
        } catch (\Exception $e) {
            dd($e);
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }

    public function delete(Request $request, Setting $id) {
        try {
            if($user = Sentinel::check()) {
                $this->data['user'] = $user;
            }
            $id->delete();
            session()->flash('success_message','Record deleted successfully!');
            return redirect()->route('campaign.index');
        } catch (\Exception $e) {
            $this->messageBag->add('exception_message', $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error_msg' => $e->getMessage()]);
        }
    }
}
