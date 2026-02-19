<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroAccountCodesEnum: string
{
    use BaseEnum;

    case CREDIT_NOTE = "ACCRECCREDIT";
    case INVOICE_RECEIVABLE = "ACCREC";
    case INVOICE_PAYABLE = "ACCPAY";
}
