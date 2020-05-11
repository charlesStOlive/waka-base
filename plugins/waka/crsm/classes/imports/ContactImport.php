<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $contact = new Contact();
            $contact->name = $row['name'];
            $contact->surname = $row['surname'];
            $contact->email = $row['email'];
            $contact->client_id = $row['client_id'];
            $contact->save();
        }
    }
}
