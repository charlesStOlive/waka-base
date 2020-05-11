<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Sectors Back-end Controller
 */
class Sectors extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Waka.Utils.Behaviors.DuplicateModel',
        'Backend.Behaviors.ReorderController',

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $duplicateConfig = 'config_duplicate.yaml';

    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'side-menu-sectors');
    }
}
