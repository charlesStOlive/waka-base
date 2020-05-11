<?php

namespace Waka\Crsm\Functions;

use Waka\Crsm\Models\Mission;
use Waka\Crsm\Models\Period;
use Waka\Crsm\Models\Sector;
use Waka\Utils\Classes\BaseFunction;
use Waka\Wcms\Models\Solution;

class ProjectFunctions extends BaseFunction
{
    public $model;

    public function getDataSource()
    {
        return \Waka\Utils\Models\DataSource::where('model', 'Project')->first();
    }

    public function listFunctionAttributes()
    {
        return [
            'allMissions' => [
                'name' => "Liste des missions du projet",
                'outputs' => [
                    'relations' => [
                        'missions' => [],
                    ],
                ],
            ],
            'missionsByPeriod' => [
                'name' => "Liste des missions du projet par periode",
                'attributes' => [
                    'periods' => [
                        'label' => "Choisissez une ou plusieurs periodes",
                        'type' => "taglist",
                        'options' => Period::lists('name', 'id'),
                    ],
                ],
                'outputs' => [
                    'relations' => [
                        'missions' => [],
                    ],
                ],
            ],
            'missionsTemplate' => [
                'name' => "Liste des missions template",
                'attributes' => [
                    'missions' => [
                        'label' => "Choisissez une ou plusieurs mission",
                        'type' => "taglist",
                        'options' => Mission::where('is_template', true)->lists('name', 'id'),
                    ],
                ],
                'outputs' => [
                    'models' => [
                        Mission::where('is_template', true)->first()->toArray(),
                    ],
                ],
            ],
            'solutionsFiltered' => [
                'name' => "Liste des solutions",
                'attributes' => [
                    'solutions' => [
                        'label' => "Choisissez une ou plusieurs solutions",
                        'type' => "taglist",
                        'options' => Solution::lists('name', 'id'),
                    ],
                    'width' => \Config::get('waka.cloudis::ImageOptions.width'),
                    'height' => \Config::get('waka.cloudis::ImageOptions.height'),
                    'crop' => \Config::get('waka.cloudis::ImageOptions.crop'),
                    'gravity' => \Config::get('waka.cloudis::ImageOptions.gravity'),
                ],
                'outputs' => [
                    'models' => [
                        Solution::first()->toArray(),
                    ],
                    'images' => [
                        'main_image',
                    ],
                ],
            ],

            'allContacts' => [
                'name' => "Tous les contacts du projet",
                'outputs' => [
                    'relations' => [
                        'client.contacts' => [],
                    ],
                ],
            ],
            'getSectorContent' => [
                'name' => "Prendre un bloc de contenu du secteur",
                'attributes' => [
                    'codes' => [
                        'label' => "Code du bloc à utilser",
                        'type' => "taglist",
                        'options' => Sector::first()->contentCodeList(),
                    ],
                ],
                'outputs' => [
                    'values' => [
                        'text',
                        'text_html',
                    ],
                ],
            ],
        ];
    }

    public function allMissions($attributes)
    {
        $result = $this->model->missions()->get()->toArray();
        return $result;
    }
    public function missionsByPeriod($attributes)
    {
        $result = $this->model->missions()->whereIn('period_id', $attributes['periods'])->get()->toArray();
        return $result;
    }
    public function missionsTemplate($attributes)
    {
        $result = Mission::whereIn('id', $attributes['missions'])->get()->toArray();
        return $result;
    }
    public function solutionsFiltered($attributes)
    {
        $results = Solution::whereIn('id', $attributes['solutions'])->with('main_image')->get();
        $finalResult;
        foreach ($results as $key => $result) {
            $finalResult[$key] = $result->toArray();
            $options = [
                'width' => $attributes['width'] ?? null,
                'height' => $attributes['height'] ?? null,
                'crop' => $attributes['crop'] ?? 'fit',
                'gravity' => $attributes['gravity'] ?? 'center',
            ];
            $finalResult[$key]['main_image'] = [
                'path' => $result->main_image->getUrl($options),
                'width' => $attributes['width'] ?? null,
                'height' => $attributes['height'] ?? null,
            ];
        }
        return $finalResult;
    }

    public function allContacts($attributes)
    {
        $result = $this->model->client->contacts->toArray();
        return $result;
    }

    public function getSectorContent($attributes)
    {
        $contents = $this->model->client->sector->content;
        $result = [];
        foreach ($contents as $content) {
            if (in_array($content['code'], $attributes['codes'])) {
                array_push($result, $content);
            }
        }
        return $result;
    }

    // public function getCloudiImage($attributes)
    // {
    //     $result = "";
    //     return $result;
    // }

}
