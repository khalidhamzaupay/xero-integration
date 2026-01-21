<?php

namespace app\Models\Integrations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyChartOfAccountsAccount extends Model
{
    use HasFactory, SoftDeletes;

    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ThirdPartyChartOfAccountsAccount';

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
        'id',
        'name',
        'third_party_access_id',
        'integration_type',
        'type',
        'active',
        'mapping_id',
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
        'name'
    ];

    public static $allowedFilersExact = [
        'type',
        'tenant_id',
        'integration_type',
    ];

    public static $allowedFilersScope = [
    ];

    public static $includes = [
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "third_party_chart_of_accounts";


}
