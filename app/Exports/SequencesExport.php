<?php

namespace App\Exports;

use App\Models\Sequence;
use Maatwebsite\Excel\Concerns\FromCollection;

class SequencesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sequence::all();
    }
}
