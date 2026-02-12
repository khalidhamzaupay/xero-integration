<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyTax extends Model
{
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ThirdPartyTax';

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
        'active',
        'integration_type',
        'mapping_id',
        'third_party_access_id',
        'sales_tax_group_id',
        'purchase_tax_group_id',
        'apply_on_sales',
        'apply_on_purchases',
        'mapping_sales_tax_rate_id',
        'mapping_purchase_tax_rate_id',
        'merchant_id'
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
        'merchant_id'
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
    protected $table = "third_party_taxes";
}
