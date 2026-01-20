<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ThirdPartyMapping extends Model
{
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
        'tenant_id',
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
    ];

    public static $allowedFilersExact = [
        'id',
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
