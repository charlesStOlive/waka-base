<?php namespace Waka\Crsm\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'waka_crsm_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public function listCountrys()
    {
        return Country::lists('name', 'id');
    }
    // public function listTypes()
    // {
    //     return Type::lists('name', 'id');
    // }
    public function listSectors()
    {
        return Sector::lists('name', 'id');
    }

}
