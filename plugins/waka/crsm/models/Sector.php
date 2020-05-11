<?php namespace Waka\Crsm\Models;

use Model;

/**
 * Sector Model
 */
class Sector extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\NestedTree;
    use \Waka\Cloudis\Classes\Traits\CloudiTrait;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_crsm_sectors';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

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
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'parent_id',
        'nest_left',
        'nest_right',
        'nest_depth',

    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'clients' => 'Waka\Crsm\Models\Client',
        //'contents' => 'Waka\Publisher\Models\Content'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $morphToMany = [
        'montages' => [
            'Waka\Cloudis\Models\Montage',
            'name' => 'montageable',
            'table' => 'waka_cloudis_montageables',
        ],
    ];
    public $attachOne = [
        'main_image' => 'Waka\Cloudis\Models\CloudiFile',
        'masque' => 'Waka\Cloudis\Models\CloudiFile',
    ];
    public $attachMany = [];

    public function afterSave()
    {
        $this->updateCloudiRelations('attach');
    }
    public function afterDelete()
    {
        $this->clouderDeleteAll();
    }

    /**
     * LIST
     */
    public function contentCodeList()
    {
        trace_log(Settings::get('content_codes'));
        $codes = Settings::get('content_codes');
        $options = [];
        foreach ($codes as $code) {
            $options[$code] = $code;
        }
        return $options;
    }

    //
    public function returnParentValue($value)
    {
        if ($this->{$value}) {
            return $this;
        } else {
            $parents = $this->getParents()->sortByDesc('nest_depth');
            foreach ($parents as $parent) {
                if ($parent->{$value} != null) {
                    return $parent;
                }
            }
        }
    }

    public function findParentId($searchedId)
    {
        if ($this->id == $searchedId) {
            return $this;
        }
        if (!$this->nested_depth) {
            // si pas de hierarchie retourne null
            return null;
        } else {
            $parents = $this->getParents()->sortByDesc('nest_depth');
            foreach ($parents as $parent) {
                if ($parent->id == $searchedId) {
                    return $parent;
                }

            }
            // si on ne retrouve rien on retourne null
            return null;
        }

    }
    public function findParentIds($searchedIds)
    {
        //transform array
        $searchedIds = array_pluck($searchedIds, 'sector_id');
        if (in_array($this->id, $searchedIds)) {
            return $this;
        }
        // s il n'a pas de nest_depth c'est un root !
        if (!$this->nest_depth) {
            //trace_log("c'est un root il n'exite pas de parent on retourne null");
            return null;
        } else {
            $parents = $this->getParents()->sortByDesc('nest_depth');
            foreach ($parents as $parent) {
                if (in_array($parent->id, $searchedIds)) {
                    return $parent;
                }

            }
            // si on ne retrouve rien on retourne null
            //trace_log("on a rien trouvé,  on retourne null");
            return null;
        }

    }
}
