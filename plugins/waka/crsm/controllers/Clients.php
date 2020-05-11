<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Clients Back-end Controller
 */
class Clients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Waka.Utils.Behaviors.PopupActions',
        'Waka.Worder.Behaviors.WordBehavior',
        'Waka.ImportExport.Behaviors.ExcelImport',
        'Waka.ImportExport.Behaviors.ExcelExport',
        'Waka.Mailer.Behaviors.MailBehavior',
        'Waka.Pdfer.Behaviors.PdfBehavior',
        'Waka.Mailtoer.Behaviors.MailtoBehavior',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'side-menu-clients');
    }
}
