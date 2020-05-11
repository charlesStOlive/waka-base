<?php namespace Waka\Crsm;

use Backend;
use Lang;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;

/**
 * crsm Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    //
    public $require = [
        'Rainlab.User',
        'Toughdeveloper.Imageresizer',
        'Waka.Utils',
        'Waka.ImportExport',
        'Waka.Cloudis',
        'Waka.Informer',
        'Waka.Worder',
    ];
    //
    public function pluginDetails()
    {
        return [
            'name' => 'crsm',
            'description' => 'No description provided yet...',
            'author' => 'waka',
            'icon' => 'icon-handshake-o',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

        CombineAssets::registerCallback(function ($combiner) {
            $combiner->registerBundle('$/waka/crsm/assets/css/simple_grid/simple-table.less');
        });

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // \Waka\Publisher\Controllers\Documents::extend(function ($controller) {
        //     $controller->implement[] = 'Waka.Crsm.Contents.ContentProjectMission';
        // });

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Waka\Crsm\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'waka.crsm.user.admin' => [
                'tab' => 'Waka CRSM',
                'label' => 'Administrateur de CRSM',
            ],
            'waka.crsm.user.manager' => [
                'tab' => 'Waka CRSM',
                'label' => 'Manager de CRSM',
            ],
            'waka.crsm.user' => [
                'tab' => 'Waka CRSM',
                'label' => 'Utilisateur de CRSM',
            ],
            'waka.crsm.reader' => [
                'tab' => 'Waka CRSM',
                'label' => 'Peut lire mais pas modifier CRSM',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'crsm' => [
                'label' => Lang::get('waka.crsm::lang.menu.title'),
                'url' => Backend::url('waka/crsm/clients'),
                'icon' => 'icon-handshake-o',
                'permissions' => ['waka.crsm.*'],
                'order' => 001,
                'sideMenu' => [
                    'side-menu-clients' => [
                        'label' => Lang::get('waka.crsm::lang.menu.clients'),
                        'icon' => 'icon-building',
                        'url' => Backend::url('waka/crsm/clients'),
                    ],
                    'side-menu-contacts' => [
                        'label' => Lang::get('waka.crsm::lang.menu.contacts'),
                        'icon' => 'icon-users',
                        'url' => Backend::url('waka/crsm/contacts'),
                    ],
                    'side-menu-projects' => [
                        'label' => Lang::get('waka.crsm::lang.menu.projects'),
                        'icon' => 'icon-briefcase',
                        'url' => Backend::url('waka/crsm/projects'),
                    ],
                    'side-menu-missions' => [
                        'label' => Lang::get('waka.crsm::lang.menu.missions'),
                        'icon' => 'icon-road',
                        'url' => Backend::url('waka/crsm/missions'),
                        'permissions' => ['waka.crsm.admin'],
                    ],
                    'side-menu-sectors' => [
                        'label' => Lang::get('waka.crsm::lang.menu.sectors'),
                        'icon' => 'icon-users',
                        'url' => Backend::url('waka/crsm/sectors'),
                        'permissions' => ['waka.crsm.admin'],
                    ],
                    'side-menu-project_states' => [
                        'label' => Lang::get('waka.crsm::lang.menu.project_states'),
                        'icon' => 'icon-users',
                        'url' => Backend::url('waka/crsm/projectStates'),
                        'permissions' => ['waka.crsm.admin'],
                    ],
                ],
            ],
        ];
    }
    public function registerSettings()
    {
        return [
            'crsm_settings' => [
                'label' => Lang::get('waka.crsm::lang.settings.label'),
                'description' => Lang::get('waka.crsm::lang.settings.description'),
                'category' => Lang::get('waka.utils::lang.menu.settings_category'),
                'icon' => 'icon-cog',
                'class' => 'Waka\Crsm\Models\Settings',
                'order' => 1,
                'permissions' => ['waka.crsm.admin'],
            ],
        ];
    }
}
