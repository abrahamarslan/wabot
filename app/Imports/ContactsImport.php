<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contact([
            'name'                      => $row['name'],
            'country_code'              => $row['country_code'],
            'contact'                   => $row['contact'],
            'age'                       => $row['age'],
            'city_name'                 => $row['city_name'],
            'state_name'                => $row['state_name'],
            'country_name'              => $row['country_name'],
            'address'                   => $row['address'],
            'pin'                       => $row['pin'],
            'current_location'          => $row['current_location'],
            'current_ctc'               => $row['current_ctc'],
            'expected_ctc'              => $row['expected_ctc'],
            'on_notice'                 => $row['on_notice']
        ]);
    }
}
