<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyAccess extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ThirdPartyAccess';

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
        'access_key',
        'access_token',
        'refresh_token',
        'client_id',
        'client_secret',
        'starts_at',
        'expires_at',
        'refresh_token_expires_at',
        'tenant_id',
        'assets_account_id',
        'sale_account_id',
        'purchase_account_id',
        'default_purchase_payment_account_id',
        'expense_account_id',
        'default_expense_payment_account_id',
        'state',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'starts_at'               => 'datetime',
        'expires_at'               => 'datetime',
        'refresh_token_expires_at' => 'datetime',
    ];


    public $translatable = [

    ];

    public static $allowedFilters = [
        'type',
        'access_key',
        'access_token',
        'client_id',
        'client_secret',
        'expires_at',
        'assets_account_id',
        'sale_account_id',
        'purchase_account_id',
        'default_purchase_payment_account_id',
        'expense_account_id',
        'default_expense_payment_account_id',
        'tenant_id'
    ];

    public static $allowedSorts = [
        'type',
        'access_key',
        'access_token',
        'client_id',
        'client_secret',
        'expires_at',
        'tenant_id'
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

    public static $includes = [
        'saleAccount',
        'expenseAccount',
    ];

    protected $table = "third_party_accesses";

    //<editor-fold desc="ThirdPartyAccess Relations" defaultstate="collapsed">

    public function saleAccount(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyChartOfAccountsAccount::class, 'sale_account_id');
    }
    public function expenseAccount(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyChartOfAccountsAccount::class, 'expense_account_id');
    }
    public function defaultPurchasePaymentAccount(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyChartOfAccountsAccount::class, 'default_purchase_payment_account_id');
    }
    public function defaultExpensePaymentAccount(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyChartOfAccountsAccount::class, 'default_expense_payment_account_id');
    }

    //</editor-fold>
}
