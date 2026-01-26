<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ThirdPartyOrganization extends Model
{

    public static $logAttributes = ["*"];


    protected static $logName = 'ThirdPartyOrganization';


    private $belongsTo = [];


    private $hasMany = [];


    private $belongsToMany = [];


    protected $fillable = [
        'id',
        'name',
        'integration_type',
        'third_party_access_id',
        'third_party_id',
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
        'third_party_access_id',
        'third_party_id',
        'integration_type',

    ];

    public static $allowedFilersScope = [
    ];

    public static $includes = [
    ];

    protected $table = "third_party_organizations";

    //<editor-fold desc="ThirdPartyOrganization Relations" defaultstate="collapsed">
    public function thirdPartyAccess(): HasOne
    {
        return $this->hasOne(ThirdPartyAccess::class);
    }
    //</editor-fold>
}
