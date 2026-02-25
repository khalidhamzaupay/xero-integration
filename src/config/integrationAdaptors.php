<?php
return [
    'xero' =>[
        'get'=>[
            \App\Services\Adaptors\Xero\Get\GetChartOfAccountsAdaptorXeroService::class,
           \App\Services\Adaptors\Xero\Get\GetThirdPartyTaxesAdaptorXeroService::class,
        ],
        'export'=>[
            //Create
//            \App\Services\Adaptors\Xero\Create\SendCreatedCustomerAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Create\SendCreatedProductAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Create\SendCreatedInvoiceAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Create\SendCreatedCustomerPaymentAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Create\SendCreatedCreditAdaptorXeroService::class,
            \App\Services\Adaptors\Xero\Create\SendCreatedReturnInvoiceAdaptorXeroService::class,
//            //Update
//            \App\Services\Adaptors\Xero\Update\SendUpdatedCustomerAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Update\SendUpdatedProductAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Update\SendUpdatedInvoiceAdaptorXeroService::class,
            \App\Services\Adaptors\Xero\Update\SendUpdatedReturnInvoiceAdaptorXeroService::class,
//            //Delete
//            \App\Services\Adaptors\Xero\Delete\SendDeletedProductAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Delete\SendDeletedInvoiceAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Delete\SendDeletedCustomerPaymentAdaptorXeroService::class,
//            \App\Services\Adaptors\Xero\Delete\SendDeletedCreditAdaptorXeroService::class,
            \App\Services\Adaptors\Xero\Delete\SendDeletedReturnInvoiceAdaptorXeroService::class,

        ]
    ],

];
