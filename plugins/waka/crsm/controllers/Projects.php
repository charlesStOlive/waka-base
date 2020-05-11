<?php namespace Waka\Crsm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Projects Back-end Controller
 */
class Projects extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ReorderController',
        'Waka.Utils.Behaviors.SidebarInfoBehavior',
        'Waka.Utils.Behaviors.DuplicateModel',
        'Waka.Utils.Behaviors.PopupActions',
        'Waka.Worder.Behaviors.WordBehavior',
        'Waka.ImportExport.Behaviors.ExcelImport',
        'Waka.Mailer.Behaviors.MailBehavior',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $sidebarInfoConfig = 'config_sidebar_info.yaml';

    public $duplicateConfig = 'config_duplicate.yaml';

    protected $missionTemplatesListWidget;
    protected $missionTemplatesFilterWidget;

    public function update($id)
    {
        $this->bodyClass = 'compact-container';
        return $this->asExtension('FormController')->update($id);
    }

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Waka.Crsm', 'crsm', 'projects');

        $this->missionTemplatesListWidget = $this->createMissionTemplatesListWidget();
    }
    public function relationExtendRefreshResults($field)
    {
        return ['#sidebar_info' => $this->makePartial('sidebar_info')];
    }
    /**
     * DEBUT REORDER
     * Partie pour le reorder. Non transformé en behavior à cause de reorderExtendQuery
     * Il faut ajouter :
     *  un bouton _relation_button_reorder
     *  le config reorder : public $relationConfig = 'config_relation.yaml';
     *  le behavior 'Backend.Behaviors.RelationController'
     *
     */

    public function onLoadReorder()
    {
        $this->vars['manageId'] = post("manageId");
        $this->reorder();
        return $this->makePartial('reorder');
    }

    public function reorderExtendQuery($query)
    {
        if (isset($this->params[0])) {
            $query->where('project_id', (int) $this->params[0]);
        } else {
            throw new \Exception('Category\'s ID must be given for reordering of Projects.');
        }
    }

    public function onCloseReorder()
    {
        $modelId = post('manageId');
        $model = \Waka\Crsm\Models\Project::find($modelId);
        $this->initForm($model);
        $this->initRelation($model, "missions");
        return $this->relationRefresh("missions");
    }

    /**
     * FIN REORDER
     */

    public function onAddMissionTemplates()
    {
        $manageId = post('manage_id');
        //trace_log("id = ".$manageId);
        $this->vars['manageId'] = $manageId;
        $this->vars['missionTemplatesListWidget'] = $this->missionTemplatesListWidget;

        #Variable necessary for the Filter funcionality
        //$this->vars['missionTemplatesFilterWidget'] = $this->missionTemplatesFilterWidget;

        #Process the custom list partial, The name you choose here will be the partials file name
        return $this->makePartial('mission_template_list');
    }
    protected function createMissionTemplatesListWidget()
    {

        #First we need config for the list, as described in video tutorials mentioned at the beginning.
        # Specify which list configuration file use for this list
        $config = $this->makeConfig('$/waka/crsm/models/mission/columns.yaml');

        # Specify the List model
        $config->model = new \Waka\Crsm\Models\Mission;

        # Lets configure some more things like report per page and lets show checkboxes on the list.
        # Most of the options mentioned in https://octobercms.com/docs/backend/lists#configuring-list # will work
        $config->recordsPerPage = '30';
        $config->showCheckboxes = 'true';

        # Here we will actually make the list using Lists Widget
        $widget_missionTemplate = $this->makeWidget('Backend\Widgets\Lists', $config);

        #For the optional Step 4. Alter product list query before displaying it.
        # We will bind to list.extendQuery event and assign a function that should be executed to extend
        # the query (the function is defined in this very same controller file)
        $widget_missionTemplate->bindEvent('list.extendQuery', function ($query) {
            $this->missionTemplateExtendQuery($query);
        });

        # Step 3. The filter part, we must define the config, really similar to the Product list widget config
        # Filter configuration file
        // $filterConfig = $this->makeConfig('$/waka/crsm/models/mission/filter_relation.yaml');

        // # Use Filter widgets to make the widget and bind it to the controller
        // $filterWidget = $this->makeWidget('Backend\Widgets\Filter', $filterConfig);
        // $filterWidget->bindToController();

        # We need to bind to filter.update event in order to refresh the list after selecting
        # the desired filters.
        // $filterWidget->bindEvent('filter.update', function () use ($widget_missionTemplate, $filterWidget) {
        //     return $widget_missionTemplate->onRefresh();
        // });

        // #Finally we are attaching The Filter widget to the Product widget.
        // $widget_missionTemplate->addFilter([$filterWidget, 'applyAllScopesToQuery']);

        // $this->missionTemplatesFilterWidget = $filterWidget;

        # Dont forget to bind the whole thing to the controller
        $widget_missionTemplate->bindToController();

        #Return the prepared widget object
        return $widget_missionTemplate;

    }

    public function missionTemplateExtendQuery($query)
    {
        $query->where('is_template', true);
    }

    public function onMissionTemplatesAdd()
    {
        //trace_log("onMissionTemplateAdd");
        $modelId = post('_manageId');
        $model = \Waka\Crsm\Models\Project::find($modelId);
        $checked = post('checked');

        if ($checked ?? false) {
            foreach ($checked as $relationId) {
                $relation = \Waka\Crsm\Models\Mission::find($relationId);
                $newRelation = $relation->replicate();
                $newRelation->is_template = false;
                $model->missions()->add($newRelation);
                $newRelation->sort_order = $newRelation->id;
                $newRelation->save();
            }
        }
        $this->initForm($model);
        $this->initRelation($model, "missions");

        return $this->relationRefresh("missions");
    }
}
