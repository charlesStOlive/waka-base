<?php namespace Waka\Crsm\Classes\Imports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClasseurCrsmProjectMissionImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
       //trace_log("sheets");
        return [
            'project_states' => new ProjectStateImport(),
            'projects' => new ProjectImport(),
            'missions' => new MissionImport(),
        ];
    }
}