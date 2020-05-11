<?php

namespace Waka\Crsm\Classes\Imports;

use Waka\Crsm\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Country([
            'name'  => $row['name'],
            'code' => $row['code'],
        ]);
    }
}