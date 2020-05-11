<?php namespace Waka\Crsm\Models;

use Model;

/**
 * Project Model
 */
class Project extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sluggable;
    use \Waka\Cloudis\Classes\Traits\CloudiTrait;
    protected $slugs = [
        'slug' => ['name', 'id'],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_crsm_projects';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = ['content'];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = ['projectPeriodTotal', 'mensuelPeriodTotal', 'mensuelPeriod', 'mensuelUser'];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = ['missions'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'closed_at',
        'closed_presvision_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        "missions" => "Waka\Crsm\Models\Mission",
    ];
    public $belongsTo = [
        'contact' => 'Waka\Crsm\Models\Contact',
        'client' => 'Waka\Crsm\Models\Client',
        'cp' => ['\Backend\Models\User', 'key' => 'cp_id'],
        'project_state' => 'Waka\Crsm\Models\ProjectState',
    ];
    public $belongsToMany = [
        // 'missions' => [
        //     'Waka\Crsm\Models\Mission',
        //     'table' => 'waka_crsm_missions_projects',
        //     'pivot' => ['amount', 'description', 'qty'],
        // ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'sends' => ['Waka\Utils\Models\SourceLog', 'name' => 'send_targeteable'],
    ];
    public $morphToMany = [
        'montages' => [
            'Waka\Cloudis\Models\Montage',
            'name' => 'montageable',
            'table' => 'waka_cloudis_montageables',
            'pivot' => ['errors'],
        ],
    ];
    public $attachOne = [
        'picture_1' => 'Waka\Cloudis\Models\CloudiFile',
        'picture_2' => 'Waka\Cloudis\Models\CloudiFile',
        'picture_3' => 'Waka\Cloudis\Models\CloudiFile',
    ];
    public $attachMany = [];

    /**
     * EVENT
     */
    public function beforeSave()
    {
        // $calcul = new \Waka\Utils\Classes\Aggregator();
        // $rowAmount = $this->missions->lists('amount') ?? null;
        // $rowQty = $this->missions->lists('qty') ?? null;
        // if ($rowAmount && $rowQty) {
        //     $this->total = $calcul->operate2Rows($rowAmount, $rowQty);
        // }

        //

    }
    public function afterSave()
    {
        $this->updateCloudiRelations('attach');
    }
    public function afterDelete()
    {
        $this->clouderDeleteAll();
    }

    /**
     * LISTS
     */
    public function listContacts()
    {
        //trace_log(\Backend\Models\User::lists('first_name', 'id'));
        if ($this->client_id) {
            //trace_log($this->client_id);
            return Contact::where('client_id', '=', $this->client_id)->lists('name', 'id');
        } else {
            return Contact::lists('name', 'id');
        }

    }
    public function listProjectState()
    {
        return ProjectState::lists('name', 'id');

    }
    public function listBU()
    {
        return \Backend\Models\User::lists('first_name', 'id');

    }
    public function getProjectPeriodTotalAttribute()
    {
        return $this->missions->where('period_id', 1)->sum('total');
    }
    public function getMensuelPeriodAttribute()
    {
        return $this->missions->where('period_id', '<>', 1)->sum('total');
    }
    public function getMensuelPeriodTotalAttribute()
    {
        return $this->mensuelPeriod * 12;
    }
    public function getMensuelUserAttribute()
    {
        $user_pot = $this->nb_user_pot;
        if ($user_pot) {
            $total = ($this->mensuelPeriod * 12 * 3 + $this->projectPeriodTotal) / 3 / 12 / $user_pot;
            return round($total, 2);

        }
        return null;

    }
}
