<?php

namespace app\Models\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FailSyncIntegration extends Model
{
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'FailSyncIntegration';

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
        'sync_integration_id',
        'object_id',
        'object_type',
        'message',
        'type',
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

    public static $allowedSorts = [
        'type',
        'created_at'
    ];

    public static $allowedFilters = [
        'object_type',
    ];

    public static $allowedFilersExact = [
        'id',
        'type',
        'tenant_id',
        'object_id',
    ];

    public static $allowedFilersScope = [
    ];

    public static $includes = [
        'object',
        'user',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "fail_sync_integrations";

    //<editor-fold desc="FailSyncIntegration Relations" defaultstate="collapsed">
    public function object(): MorphTo
    {
        return $this->morphTo();
    }
    public function syncIntegration(): BelongsTo
    {
        return $this->belongsTo(SyncIntegration::class);
    }
    //</editor-fold>
}
