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
                'type'       => 'type',
                'contact_id' => 'contact_id',
                'date'       => 'date',
                'due_date'   => 'due_date',
                'status'     => 'status',
                'reference'  => 'reference',
                'notes'      => 'notes',
                'subtotal'   => 'subtotal',
                'total_tax'  => 'total_tax',
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
                'product_id'    => 'item_code',
                'description'   => 'description',
                'quantity'      => 'quantity',
                'unit_amount'   => 'unit_amount',
                'account_code'  => 'account_code',
                'tax_type'      => 'tax_type',
                'tax_amount'    => 'tax_amount',
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
                'credit_note_number' => 'credit_note_number',
                'date'               => 'date',
                'contact_id'         => 'contact_id',
                'line_items'         => 'line_items',
                'status'             => 'status',
                'invoice_id'         => 'invoice_id',
                'amount'             => 'amount',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'refund_items' => [
            'table' => 'upayrefund_items',
            'fields' => [
                'id'           =>'id',
                'description'  => 'description',
                'quantity'     => 'quantity',
                'unit_amount'  => 'unit_amount',
                'item_code'    => 'item_code',
                'tax_type'     => 'tax_type',

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
                'account_code'     => 'account_code',
                'date'             => 'date',
                'amount'           => 'amount',
                'reference'        => 'reference',
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

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

        'credits' => [
            'table' => 'upaycredits',
            'fields' => [
                'id'         =>'id',
                'type'       => 'type',
                'contact_id' => 'contact_id',
                'date'       => 'date',
                'status'     => 'status',
                'reference'  => 'reference',
                'amount'     => 'amount',
                'merchant_id'=> 'merchant_id',

                'created_at'=>'created_at',
                'updated_at'=>'updated_at',
                'deleted_at'=>'deleted_at'
            ],
        ],

    ],
];
