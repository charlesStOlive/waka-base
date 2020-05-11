<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Client;
use System\Models\File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        
        
        foreach ($rows as $row) 
        {
            $client = new Client();
            $client->name = $row['name'];
            $client->slug = $row['slug'];
            $client->primary_color = $row['primary_color'];
            $client->secondary_color = $row['secondary_color'];
            $client->cp = $row['cp'];
            $client->address = $row['adresse'];
            $client->city = $row['ville'];
            $client->tel = $row['tel'];
            $client->sector_id = $row['sector_id'];
            $client->type_id = 1;
            $client->country_id = 74;
           //trace_log(plugins_path('waka/crsm/updates/files/pictures/logos/'.$row['logo']));
            $logo = new File();
            $logo->is_public = true;
            $logo->data = plugins_path('waka/crsm/updates/files/pictures/logos/'.$row['logo']);
            $client->logo_c = $logo;
            $logo->save();
            $client->save();
            
        };
        
    }
}