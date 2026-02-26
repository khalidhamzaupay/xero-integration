<?php
namespace App\Http\Resources\Xero;

use Illuminate\Http\Resources\Json\JsonResource;

class XeroReturnPaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields = config('xero.mapping.return_payments.fields');
        $refundFields = config('xero.mapping.refunds.fields');
        return [
            "CreditNote" => [
                "CreditNoteID" => $this->refund?->xeroMapping->third_party_id
            ],
            "Account" => [
                "Code" => (string)$this->paymentMethod?->xeroMapping->third_party_id
            ],
            "Amount" => (float) $this->{$fields['amount']},
            "Date" => now()->format('Y-m-d'),
            "Reference" => "Refund for Refund #" . ($this->refund?->{$refundFields['id']})
        ];
    }
}
