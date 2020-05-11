<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Sector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SectorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Sector([
            'name'  => $row['name'],
            'slug' => $row['slug'],
            'parent_id' => $row['parent_id'],
        ]);
    }
}

