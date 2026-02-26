<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyMapping extends Model
{
    use softDeletes;
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ThirdPartyMapping';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_type',
        'object_id',
        'type',
        'third_party_code',
        'third_party_tag',
        'third_party_id',
        'merchant_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public $translatable = [

    ];

    public static $allowedFilters = [
        'type',             // e.g., 'refund', 'invoice'
        'third_party_tag',  // e.g., 'Allocated', 'Paid'
        'object_type',      // Filter by the Model class
    ];

    public static $allowedSorts = [
        'created_at',
        'type',
        'third_party_tag'
    ];

    public static $allowedFilersExact = [
        'id',
        'object_id',
        'third_party_id', // Search for a specific Xero ID
    ];

    public static $allowedFilersScope = [
        'date_starts_before',
        'date_ends_before',
        'date_in_between',
        'by_date',
    ];


    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "third_party_mappings";


    //<editor-fold desc="ThirdPartyMapping Relations" defaultstate="collapsed">
    public function object():MorphTo
    {
        return $this->morphTo();
    }

    //</editor-fold>
}
