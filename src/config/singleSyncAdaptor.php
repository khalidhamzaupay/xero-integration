<?php


return [

    'xero' => [

        'customer' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedCustomerAdaptorXeroService::class,
            'update' => \App\Services\Adaptors\Xero\Update\SendUpdatedCustomerAdaptorXeroService::class,
        ],

        'product' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedProductAdaptorXeroService::class,
            'update' => \App\Services\Adaptors\Xero\Update\SendUpdatedProductAdaptorXeroService::class,
            'delete' => \App\Services\Adaptors\Xero\Delete\SendDeletedProductAdaptorXeroService::class,
        ],

        'invoice' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedInvoiceAdaptorXeroService::class,
            'update' => \App\Services\Adaptors\Xero\Update\SendUpdatedInvoiceAdaptorXeroService::class,
            'delete' => \App\Services\Adaptors\Xero\Delete\SendDeletedInvoiceAdaptorXeroService::class,
        ],

        'customer_payment' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedCustomerPaymentAdaptorXeroService::class,
            'delete' => \App\Services\Adaptors\Xero\Delete\SendDeletedCustomerPaymentAdaptorXeroService::class,
        ],

        'credit' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedCreditAdaptorXeroService::class,
            'delete' => \App\Services\Adaptors\Xero\Delete\SendDeletedCreditAdaptorXeroService::class,
        ],

        'return_invoice' => [
            'create' => \App\Services\Adaptors\Xero\Create\SendCreatedReturnInvoiceAdaptorXeroService::class,
            'update' => \App\Services\Adaptors\Xero\Update\SendUpdatedReturnInvoiceAdaptorXeroService::class,
            'delete' => \App\Services\Adaptors\Xero\Delete\SendDeletedReturnInvoiceAdaptorXeroService::class,
        ],

    ],

];
