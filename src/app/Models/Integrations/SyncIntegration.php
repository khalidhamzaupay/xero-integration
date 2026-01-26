<?php

namespace App\Models\Integrations;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncIntegration extends Model
{
    protected $with=['createdBy'];

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'SyncIntegrations';

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
        'type',
        'end_at',
        'merchant_id',
        'status',
        'created_by',
        'method'
    ];

    public static $allowedSorts = [
        'type',
        'created_at'
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
        'type',
        'merchant_id',
        'status',
        'created_by',
    ];

    public static $allowedFilersScope = [
    ];

    public static $includes = [
        'user'
    ];
    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "sync_integrations";


    //<editor-fold desc="SyncIntegration Relations" defaultstate="collapsed">
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    //</editor-fold>
}
