<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpayCustomerPaymentsSeeder extends Seeder
{
    public function run(): void
    {
        // Get all authorized invoices
        $invoices = DB::table('upayinvoices')
            ->where('status', 'AUTHORISED')
            ->get();

        $customerPayments = [];
        $payments = [];

        foreach ($invoices as $invoice) {
            // Random payment method for this merchant
            $paymentMethod = DB::table('payment_methods')->inRandomOrder()->first();

            $amount = $invoice->total ?? 0;

            // Insert payment
            $paymentId = DB::table('upaypayments')->insertGetId([
                'payment_method_id' => $paymentMethod->id,
                'amount'            => $amount,
                'date'              => now()->toDateString(),
                'reference'         => 'PMT-' . $invoice->id,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Insert customer payment
            $customerPayments[] = [
                'invoice_id'   => $invoice->id,
                'account_code' => $paymentMethod->id,
                'date'         => now()->toDateString(),
                'amount'       => $amount,
                'reference'    => 'CUSTPMT-' . $invoice->id,
                'merchant_id'  => $invoice->merchant_id,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('upaycustomer_payments')->insert($customerPayments);
    }
}
