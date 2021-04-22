<?php

namespace App\Exports;

use App\Models\Message;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MessagesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return Message::all();
//    }

    public function view(): View
    {
        return view('themes.default.pages.export.table', [
            'messages' => Message::where('type','received')->get()
        ]);
    }
}
