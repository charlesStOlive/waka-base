<?php

namespace Waka\Crsm\Functions;

use Waka\Crsm\Models\ProjectState;
use Waka\Utils\Classes\BaseFunction;
use Waka\Wcms\Models\Need;
use Waka\Wcms\Models\Solution;

class ContactFunctions extends BaseFunction
{
    public $model;

    public function listFunctionAttributes()
    {
        return [
            'linkedProjects' => [
                'name' => "Liste des projets du contact",
                'attributes' => [
                    'project_state' => [
                        'label' => "Choisissez une ou plusieurs mission",
                        'type' => "taglist",
                        'options' => ProjectState::lists('name', 'id'),
                    ],
                ],
                'outputs' => [
                    'relations' => [
                        'projects' => ['project_state'],
                    ],
                ],
            ],
            'solutionsFiltered' => [
                'name' => "Liste de besoins",
                'attributes' => [
                    'needs' => [
                        'label' => "Choisissez un ou plusieurs besoins",
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
            'needsFiltered' => [
                'name' => "Liste de solutions",
                'attributes' => [
                    'needs' => [
                        'label' => "Choisissez une ou plusieurs solutions",
                        'type' => "taglist",
                        'options' => Need::lists('name', 'id'),
                    ],
                    'width' => \Config::get('waka.cloudis::ImageOptions.width'),
                    'height' => \Config::get('waka.cloudis::ImageOptions.height'),
                    'crop' => \Config::get('waka.cloudis::ImageOptions.crop'),
                    'gravity' => \Config::get('waka.cloudis::ImageOptions.gravity'),
                ],
                'outputs' => [
                    'models' => [
                        Need::first()->toArray(),
                    ],
                    'images' => [
                        'main_image',
                    ],
                ],
            ],

        ];
    }

    public function linkedProjects($attributes)
    {
        $result = $this->model->projects()->whereHas('project_state', function ($query) use ($attributes) {
            $query->whereIn('id', $attributes['project_state']);
        })->with('project_state')->get()->toArray();
        //trace_log($result);
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
                'width' => $attributes['width'],
                'height' => $attributes['height'],
            ];
        }
        return $finalResult;
    }

    public function needsFiltered($attributes)
    {
        $results = Need::whereIn('id', $attributes['needs'])->with('main_image')->get();
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
                'width' => $attributes['width'],
                'height' => $attributes['height'],
            ];
        }
        return $finalResult;
    }

    public function projectByStateByDate($attributes)
    {
        return $this->model->projects()->whereHas('project_state', function ($query) use ($attributes) {
            $query->whereIn('id', $attributes['project_state']);
        })->whereBetween('updated_at', [$attributes['start_date'], $attributes['end_date']])
            ->with('project_state')->get()->toArray();
    }

}
