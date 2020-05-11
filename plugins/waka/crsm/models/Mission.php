<?php namespace Waka\Crsm\Models;

use Model;

/**
 * Mission Model
 */
class Mission extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    public $timestamps = false;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_crsm_missions';

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
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        // 'projects' => [
        //     'Waka\Crsm\Models\Mission',
        //     'table' => 'waka_crsm_missions_projects',
        //     'pivot' => ['amount', 'description', 'qty', ],
        // ],
    ];
    public $belongsTo = [
        'project' => 'Waka\Crsm\Models\Project',
        'period' => 'Waka\Crsm\Models\Period',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getPeriodOptions()
    {
        return Period::lists('name', 'id');
    }

    public function beforeSave()
    {
        trace_log("before save mission " . $this->name);
        if (is_numeric($this->amount) && is_numeric($this->qty)) {
            $this->total = $this->amount * $this->qty;
        }
    }

    public function filterFields($fields, $context = null)
    {

        if (is_numeric($fields->qty->value) && is_numeric($fields->amount->value)) {
            $fields->total->value = $fields->qty->value * $fields->amount->value;
        }
    }
}
