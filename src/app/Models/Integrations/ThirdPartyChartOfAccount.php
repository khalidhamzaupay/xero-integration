<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyChartOfAccount extends Model
{
    use HasFactory, SoftDeletes;

    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ThirdPartyChartOfAccount';

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
        'name'
    ];

    public static $allowedFilersExact = [
        'type',
        'merchant_id',
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
