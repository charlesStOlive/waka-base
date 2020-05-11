<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Mission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MissionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Mission([
            'name'  => $row['name'],
            'is_template' => $row['is_template'],
            'project_id' => $row['project_id'],
            'description' => $row['description'],
            'qty' => $row['qty'],
            'amount' => $row['amount'],
        ]);
    }
}

