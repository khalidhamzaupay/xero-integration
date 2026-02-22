<?php
return [
    'mapping'=>[
        'customers'=>[
            'table'=>'upaycustomers',
            'fields'=>[
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

            ],
        ],
        'products'=>[
            'table' => 'products',
            'fields' => [
                'code'        => '',
                'name'        => '',
                'description' => '',

                // sales
                'sale_price'  => '',
                'sale_tax'    => '',

                // purchase
                'cost_price'  => '',
                'purchase_tax'=> '',

                // inventory
                'quantity'    => '',
                'is_inventory'=> '',

                // status
                'active'      => '',
                'merchant_id'=>'',

            ],
        ],
        'invoices'=>[
            'table' => 'invoices',
            'fields' => [
                'type'       => '',
                'contact_id' => '',
                'date'       => '',
                'due_date'   => '',
                'status'     => '',
                'reference'  => '',
                'notes'      => '',
                'subtotal'   => '',
                'total_tax'  => '',
                'total'      => '',
                'merchant_id'=>'',
            ],
        ],
        'invoice_items'=>[
            'table' => 'invoice_items',
            'fields' => [
                'item_code'     => '',
                'description'   => '',
                'quantity'      => '',
                'unit_amount'   => '',
                'account_code'  => '',
                'tax_type'      => '',
                'tax_amount'    => '',
                'discount_rate' => '',
            ],
        ],
        'refunds'=> [
            'table' => 'refunds',
            'fields' => [
                'credit_note_number' => '',
                'date'               => '',
                'contact_id'         => '',
                'line_items'         => '',
                'status'             => '',
                'invoice_id'         => '',
                'amount'             => '',
            ],
        ],

        'refund_items' => [
            'table' => 'refund_items',
            'fields' => [
                'description'  => '',
                'quantity'     => '',
                'unit_amount'  => '',
                'item_code'    => '',
                'tax_type'     => '',
            ],
        ],
        'customer_payments' => [
            'table' => 'customer_payments',
            'fields' => [
                'invoice_id'       => '',
                'account_code'     => '',
                'date'             => '',
                'amount'           => '',
                'reference'        => '',
                'merchant_id'      => '',
            ],
        ],
        'payments' => [
            'table' => 'payments',
            'fields' => [
                'payment_method_id' => '',
                'amount'            => '',
                'date'              => '',
                'reference'         => '',
            ],
        ],
        'payment_methods' => [
            'table' => 'payment_methods',
            'fields' => [
                'name' => 'name',
            ],
        ],
        'credits' => [
            'table' => 'credits',
            'fields' => [
                'type'       => '',
                'contact_id' => '',
                'date'       => '',
                'status'     => '',
                'reference'  => '',
                'amount'     => '',
                'merchant_id'=> '',
            ],
        ],

    ],
];
