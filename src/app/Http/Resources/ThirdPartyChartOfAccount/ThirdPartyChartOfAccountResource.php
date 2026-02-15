<?php
namespace App\Http\Resources\ThirdPartyChartOfAccount;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
class ThirdPartyChartOfAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [

            'id'                    =>  $this->id,
            'name'                  =>  $this->name,
            'type'                  =>  $this->type,
            'integration_type'      =>  $this->integration_type,
            'mapping_id'            =>  $this->mapping_id,
            'third_party_access_id' =>  $this->third_party_access_id,
            'merchant_id'           =>  $this->merchant_id,
            'state'                 =>  $this->state,
            'created_at'            =>$this->created_at?->toDateTimeString(),
        ];
    }
}

