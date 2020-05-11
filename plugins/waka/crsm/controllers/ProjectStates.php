<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Project States Back-end Controller
 */
class ProjectStates extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController',
        'Waka.ImportExport.Behaviors.ExcelImport',

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'side-menu-project_states');
    }
}
