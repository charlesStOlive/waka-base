<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date as DateConvert;

class ProjectImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row['name']){
                $project = new Project();
                $project->name = $row['name'];
                $project->client_id = $row['client_id'];
                $project->contact_id = $row['contact_id'];
                $project->cp_id = $row['cp_id'];
                $project->project_state_id = $row['project_state_id'];
                if($row['closed_at']) $project->closed_at = DateConvert::excelToDateTimeObject($row['closed_at']);
                $project->save();
            }

        }
    }
}
				

