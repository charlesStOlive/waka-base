<?php

namespace Waka\Crsm\Functions;

use Waka\Crsm\Models\ProjectState;
use Waka\Crsm\Models\Sector;
use Waka\Utils\Classes\BaseFunction;

class ClientFunctions extends BaseFunction
{
    public $model;

    public function listFunctionAttributes()
    {
        return [
            'ProjectActifsOrClosed' => [
                'name' => "Tous les projet actifs OU fermés",
                'attributes' => [
                    'active' => [
                        'label' => "Active",
                        'type' => "checkbox",
                    ],
                ],
                'outputs' => [
                    'relations' => [
                        'projects' => ['project_state'],
                    ],
                ],
            ],
            'ProjectByState' => [
                'name' => "Tous les projet filtré sur un ou plusieurs états",
                'attributes' => [
                    'project_state' => [
                        'label' => "Etat d'un projet",
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
            'ProjectByStateByDate' => [
                'name' => "Tous les projet filtré sur un état sur une période",
                'attributes' => [
                    'project_state' => [
                        'label' => "Etat d'un projet",
                        'type' => "dropdown",
                        'options' => ProjectState::lists('name', 'id'),
                    ],
                    'start_date' => [
                        'label' => "Date de debut",
                        'type' => "datepicker",
                    ],
                    'end_date' => [
                        'label' => "date de fin",
                        'type' => "datepicker",
                    ],
                ],
                'outputs' => [
                    'relations' => [
                        'projects' => ['project_state'],
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
                    'outputs' => [
                        'infos' => [
                            '**nomBlocSecteur**',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function ProjectActifsOrClosed($attributes)
    {
        $result = $this->model->projects()->whereHas('project_state', function ($query) use ($attributes) {
            $query->where('is_running', boolval($attributes['active']));
        })->with('project_state')->get()->toArray();
        //trace_log($result);
        return $result;
    }

    public function projectByState($attributes)
    {
        $result = $this->model->projects()->whereHas('project_state', function ($query) use ($attributes) {
            $query->whereIn('id', $attributes['project_state']);
        })->with('project_state')->get()->toArray();
        //trace_log($result);
        return $result;
    }

    public function projectByStateByDate($attributes)
    {
        return $this->model->projects()->whereHas('project_state', function ($query) use ($attributes) {
            $query->whereIn('id', $attributes['project_state']);
        })->whereBetween('updated_at', [$attributes['start_date'], $attributes['end_date']])
            ->with('project_state')->get()->toArray();
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

}
