<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Contacts Back-end Controller
 */
class Contacts extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Waka.Utils.Behaviors.SidebarInfoBehavior',
        'Waka.Utils.Behaviors.DuplicateModel',
        'Waka.Utils.Behaviors.PopupActions',
        'Waka.Worder.Behaviors.WordBehavior',
        'Waka.ImportExport.Behaviors.ExcelImport',
        'Waka.ImportExport.Behaviors.ExcelExport',
        'Waka.Cloudis.Behaviors.PopupCloudis',
        'Waka.Mailtoer.Behaviors.MailtoBehavior',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $duplicateConfig = 'config_duplicate.yaml';
    public $sidebarInfoConfig = 'config_sidebar_info.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'side-menu-contacts');
    }

    public function update($id)
    {
        $this->bodyClass = 'compact-container';
        return $this->asExtension('FormController')->update($id);
    }
}
