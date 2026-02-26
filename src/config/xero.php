<?php
return [
    'mapping'=>[
        'merchants'=>[
            'table'=>'users',
            'fields'=>[
                'id'         =>'id',
                'name'       => 'name'
            ]
        ],
        'customers'=>[
            'table'=>'upaycustomers',
            'fields'=>[
                'id'         =>'id',
                'name'       => 'name',
                'first_name' => 'first_name',
                'last_name'  => 'last_name',
                'email'      => 'email',
                'status'     => 'status',

                // address (street)
                'address_1'  => 'address_1',
                'city'       => 'city',
                'region'     => 'region',
                'country'    => 'country',
                'postal'     => 'postal',

                // phone
                'phone'      => 'phone',
                'phone_code' => 'phone_code',

                'website'    => 'website',
                'notes'      => 'notes',
                'merchant_id'=>'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at',

            ],
        ],

        'products'=>[
            'table' => 'upayproducts',
            'fields' => [
                'id'          =>'id',
                'code'        => 'code',
                'name'        => 'name',
                'description' => 'description',

                // sales
                'sale_price'  => 'sale_price',
                'sale_tax'    => 'sale_tax',

                // purchase
                'cost_price'  => 'cost_price',
                'purchase_tax'=> 'purchase_tax',

                // inventory
                'quantity'    => 'quantity',
                'is_inventory'=> 'is_inventory',

                // status
                'active'      => 'active',
                'merchant_id'=>'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'invoices'=>[
            'table' => 'upayinvoices',
            'fields' => [
                'id'         =>'id',
                'contact_id' => 'contact_id',
                'date'       => 'date',
                'due_date'   => 'due_date',
                'status'     => 'status',
                'reference'  => 'reference',
                'notes'      => 'notes',
                'subtotal'   => 'subtotal',
                'total'      => 'total',
                'merchant_id'=>'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'invoice_items'=>[
            'table' => 'upayinvoice_items',
            'fields' => [
                'id'            =>'id',
                'invoice_id'    => 'invoice_id',
                'product_id'    => 'item_code',
                'description'   => 'description',
                'quantity'      => 'quantity',
                'unit_amount'   => 'unit_amount',
                'account_code'  => 'account_code',
                'discount_rate' => 'discount_rate',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'refunds'=> [
            'table' => 'upayrefunds',
            'fields' => [
                'id'                 =>'id',
                'date'               => 'date',
                'contact_id'         => 'contact_id',
                'invoice_id'         => 'invoice_id',
                'amount'             => 'amount',
                'merchant_id'        => 'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'refund_items' => [
            'table' => 'upayrefund_items',
            'fields' => [
                'id'           =>'id',
                'refund_id'    => 'refund_id',
                'description'  => 'description',
                'quantity'     => 'quantity',
                'unit_amount'  => 'unit_amount',
                'product_id'   => 'item_code',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'customer_payments' => [
            'table' => 'upaycustomer_payments',
            'fields' => [
                'id'               =>'id',
                'invoice_id'       => 'invoice_id',
                'date'             => 'date',
                'amount'           => 'amount',
                'reference'        => 'reference',
                'payment_id'       => 'payment_id',
                'customer_id'      => 'customer_id',
                'merchant_id'      => 'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'payments' => [
            'table' => 'upaypayments',
            'fields' => [
                'id'                =>'id',
                'payment_method_id' => 'payment_method_id',
                'amount'            => 'amount',
                'date'              => 'date',
                'reference'         => 'reference',
                'merchant_id'       => 'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'payment_methods' => [
            'table' => 'payment_methods',
            'fields' => [
                'id'         =>'id',
                'name'       => 'name',
                'merchant_id'=> 'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],
        'return_payments' => [
            'table' => 'upayreturn_payments',
            'fields' => [
                'id'                => 'id',
                'amount'            => 'u_amount',
                'refund_id'         => 'u_refund_id',
                'merchant_id'       => 'u_merchant_id',
                'customer_id'       => 'u_customer_id',
                'payment_method_id' => 'u_payment_method_id',
                'date'              => 'u_date',
                'reference'         => 'u_reference',

                'created_at'        => 'created_at',
                'updated_at'        => 'updated_at',
                'deleted_at'        => 'deleted_at'
            ]
        ],

        'credits' => [
            'table' => 'upaycredits',
            'fields' => [
                'id'         =>'id',
                'customer_id'=> 'contact_id',
                'date'       => 'date',
                'status'     => 'status',
                'amount'     => 'amount',
                'payment_id' => 'payment_id',
                'merchant_id'=> 'merchant_id',
                'description'=> 'description',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

    ],
];
