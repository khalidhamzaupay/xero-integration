<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpayInvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['DRAFT', 'AUTHORISED', 'PAID', 'VOIDED'];
        $types    = ['ACCREC']; // Xero Accounts Receivable

        $invoices = [];

        for ($i = 1; $i <= 100; $i++) {
            $subtotal = rand(1000, 10000) / 100; // 10 – 100
            $tax      = round($subtotal * 0.05, 4); // 5% tax
            $total    = $subtotal + $tax;

            $date     = now()->subDays(rand(0, 60));
            $dueDate  = (clone $date)->addDays(rand(7, 30));

            $invoices[] = [
                'type'        => $types[array_rand($types)],
                'contact_id'  => rand(1, 20), // assumes customers exist
                'date'        => $date->toDateString(),
                'due_date'    => $dueDate->toDateString(),
                'status'      => $statuses[array_rand($statuses)],
                'reference'   => 'INV-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'notes'       => 'Auto generated invoice #' . $i,
                'subtotal'    => $subtotal,
                'total_tax'   => $tax,
                'total'       => $total,
                'merchant_id' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('upayinvoices')->insert($invoices);
    }
}
