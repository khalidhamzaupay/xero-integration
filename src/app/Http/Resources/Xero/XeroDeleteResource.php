<?php


namespace App\Http\Resources\Xero;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroDeleteResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [

            "Status" => "DELETED",

        ];



        return $data;
    }
}
