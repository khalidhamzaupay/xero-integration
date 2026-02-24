<?php
namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroInvoiceStatusEnum: string
{
    use BaseEnum;

    case DRAFT = "DRAFT";
    case AUTHORISED = "AUTHORISED";
    case SUBMITTED = "SUBMITTED";
    case VOIDED = "VOIDED";

    /**
     * Map internal database status to Xero status
     */
    public static function fromInternal(string $internalStatus): self
    {
        return match (strtoupper($internalStatus)) {
            'ACTIVE', 'PAID', 'POSTED', 'APPROVED' => self::AUTHORISED,
            'PENDING', 'OPEN'                      => self::DRAFT,
            'CANCELLED', 'VOID'                    => self::VOIDED,
            default                                => self::DRAFT,
        };
    }
}
