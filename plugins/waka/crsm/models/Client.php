<?php namespace Waka\Crsm\Models;

use Model;

/**
 * Client Model
 */
class Client extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \Waka\Cloudis\Classes\Traits\CloudiTrait;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_crsm_clients';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [''];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required|between:3,32',
        'slug' => 'required|unique:waka_crsm_clients',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = ['totalProjectsRunning', 'TotalProjects'];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = ['totalProjectsRunning'];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [
        'country_id',
        'sector_id',
        'type_id',
        'deleted_at',
        'cloudi_ready',
    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'users' => 'Rainlab\User\Models\User',
        'contacts' => 'Waka\Crsm\Models\Contact',
        'projects' => 'Waka\Crsm\Models\Project',
    ];
    public $belongsTo = [
        'sector' => 'Waka\Crsm\Models\Sector',
        'country' => 'Waka\Crsm\Models\Country',
        'type' => 'Waka\Crsm\Models\Type',
    ];
    public $belongsToMany = [];
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
        'logo' => 'Waka\Cloudis\Models\CloudiFile',
    ];
    public $attachMany = [];

    /**
     *
     */
    public function afterSave()
    {
        //$this->testCloudis();
        $this->updateCloudiRelations('attach');
    }
    public function afterDelete()
    {
        //$this->clouderDeleteAll();
    }

    /**
     * SCOPES
     */
    public function scopeSectorFilter($query, $filtered)
    {
        return $query->whereHas('sector', function ($q) use ($filtered) {
            $q->whereIn('id', $filtered);
        });
    }

    /**
     * Attribute
     */
    public function getCloudiThumbAttribute()
    {
        if ($this->logo) {
            return '<img src="' . $this->logo->getColumnThumb() . '">';
        } else {
            return "Pas d'image";
        }
    }
    public function getTotalProjectsRunningAttribute()
    {
        return $this->projects()->whereHas('project_state', function ($query) {
            $query->where('is_running', true);
        })->count();
    }
    public function getTotalProjectsAttribute()
    {
        return $this->projects->count();

    }

    public function getDefaultCountryAttribute()
    {
        return Settings::get('country');
    }
    public function getDefaultTypesAttribute()
    {
        return Settings::get('type');
    }
    public function getDefaultSectorAttribute()
    {
        return Settings::get('sector');
    }

}
