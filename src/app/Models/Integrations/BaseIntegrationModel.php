<?php


namespace App\Models\Integrations;

use App\Enums\IntegrationsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BaseIntegrationModel extends Model
{
    /**
     * Get the Xero-specific mapping for this object.
     */
    public function xeroMapping(?int $merchant_id = null): MorphOne
    {
        $relation = $this->morphOne(ThirdPartyMapping::class, 'object')
            ->where('type', IntegrationsType::Xero->value);

        if ($merchant_id) {
            $relation->where('merchant_id', $merchant_id);
        }

        return $relation;
    }

    /**
     * Get all failed sync integrations for this object.
     */
    public function failSyncIntegrations(): MorphMany
    {
        return $this->morphMany(FailSyncIntegration::class, 'object');
    }

    /**
     * Get the generic third-party mapping for this object.
     */
    public function thirdPartyMapping(): MorphOne
    {
        return $this->morphOne(ThirdPartyMapping::class, 'object');
    }
}
