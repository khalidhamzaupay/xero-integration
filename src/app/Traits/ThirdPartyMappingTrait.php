<?php


namespace App\Traits;

use App\Models\Integrations\ThirdPartyMapping;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait ThirdPartyMappingTrait
{
    public function saveToMapping($object, $thirdPartyId, $type, ?string $thirdPartyCode = null,$merchant_id= null,$tag = null): void
    {
        $object->thirdPartyMapping()->create(
            [
                'third_party_id' => $thirdPartyId,
                'third_party_code' => $thirdPartyCode,
                'merchant_id' => $merchant_id,
                'type' => $type,
                'third_party_tag' => $tag,
            ]);
    }

    public function saveToFailedSync($object, $type, $message, $syncIntegrationId = null): void
    {
        $object->failSyncIntegrations()->create(
            [
                'type' => $type,
                'message' => $message,
                'sync_integration_id' => $syncIntegrationId,
            ]);
    }

    protected function getMappingEntity($thirdPartyId, $targetClass, $type, $merchant_id = null,
                                        $thirdPartyCode = null, $tag = null, $mappingType = null): Model|Builder|ThirdPartyMapping|null
    {
        return ThirdPartyMapping::query()
            ->where('object_type', $targetClass)
            ->where('third_party_id', $thirdPartyId)
            ->where('type', $type)
            ->when($merchant_id, function ($query) use ($merchant_id) {
                return $query->where('merchant_id', $merchant_id);
            })
            ->when($thirdPartyCode, function ($query) use ($thirdPartyCode) {
                return $query->where('third_party_code', $thirdPartyCode);
            })
            ->when($tag, function ($query) use ($tag) {
                return $query->where('third_party_tag', $tag);
            })
            ->when($mappingType, function ($query) use ($mappingType) {
                return $query->where('mapping_type', $mappingType);
            })
            ->first();
    }

}
