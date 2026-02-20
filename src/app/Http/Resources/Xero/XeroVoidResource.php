<?php


namespace App\Http\Resources\Xero;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroVoidResource extends JsonResource
{

    public function data(Request $request): array
    {
        $data = [

            "Status" => "VOIDED",

        ];



        return $data;
    }
}
