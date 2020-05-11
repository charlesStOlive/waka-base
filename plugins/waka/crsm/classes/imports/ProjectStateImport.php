<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\ProjectState;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectStateImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ProjectState([
            'name'  => $row['name'],
            'is_running' => $row['is_running'],
        ]);
    }
}

