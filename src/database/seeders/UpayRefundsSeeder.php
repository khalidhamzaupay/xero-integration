<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpayRefundsSeeder extends Seeder
{
    public function run(): void
    {
        // Get 5 random invoices
        $invoices = DB::table('upayinvoices')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $refunds = [];
        $refundItems = [];

        foreach ($invoices as $invoice) {
            // Get first invoice item
            $item = DB::table('upayinvoice_items')
                ->where('invoice_id', $invoice->id)
                ->first();

            if (!$item) {
                continue; // skip if invoice has no items
            }

            // Refund amount = quantity * unit_amount
            $amount = $item->quantity * $item->unit_amount;

            // Insert refund
            $refundId = DB::table('upayrefunds')->insertGetId([
                'credit_note_number' => 'CR-' . $invoice->id,
                'date'               => now()->toDateString(),
                'contact_id'         => $invoice->contact_id,
                'line_items'         => '',
                'status'             => 'AUTHORISED',
                'invoice_id'         => $invoice->id,
                'amount'             => $amount,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Insert single refund item
            $refundItems[] = [
                'refund_id'   => $refundId,
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_amount' => $item->unit_amount,
                'item_code'   => $item->item_code,
                'tax_type'    => $item->tax_type,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('upayrefund_items')->insert($refundItems);
    }
}
