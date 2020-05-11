<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Missions Back-end Controller
 */
class Missions extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Waka.Utils.Behaviors.DuplicateModel',
        'Waka.ImportExport.Behaviors.ExcelImport',

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $duplicateConfig = 'config_duplicate.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'missions');
    }
    public function listExtendQuery($query)
    {
        return $query->where('is_template', true);
    }

}
