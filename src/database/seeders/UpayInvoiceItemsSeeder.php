<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpayInvoiceItemsSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = DB::table('upayinvoices')->pluck('id');

        $items = [];

        foreach ($invoices as $invoiceId) {
            $itemsCount = rand(1, 5);

            for ($i = 1; $i <= $itemsCount; $i++) {
                $quantity   = rand(1, 10);
                $unitAmount = rand(500, 5000) / 100;
                $taxAmount  = round(($quantity * $unitAmount) * 0.05, 4);

                $items[] = [
                    'invoice_id'    => $invoiceId,
                    'item_code'     => 'ITEM-' . rand(100, 999),
                    'description'   => 'Invoice item for invoice #' . $invoiceId,
                    'quantity'      => $quantity,
                    'unit_amount'   => $unitAmount,
                    'account_code'  => '400',
                    'tax_type'      => 'OUTPUT',
                    'tax_amount'    => $taxAmount,
                    'discount_rate' => rand(0, 20),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }

        DB::table('upayinvoice_items')->insert($items);
    }
}
