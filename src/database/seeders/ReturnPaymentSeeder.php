<?php


namespace Database\Seeders;

use App\Models\Integrations\Refund;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReturnPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $refunds = Refund::whereHas('xeroMapping')->get();
        foreach ($refunds as $refund) {
            DB::table('upayreturn_payments')->insert([
                'u_amount' => $refund->amount,
                'u_date' => now()->format('Y-m-d'),
                'u_reference' => 'Xero Return Payment Test',
                'u_refund_id' => $refund->id,
                'u_payment_method_id' => 1,
                'u_merchant_id' => 1,
                'u_customer_id' => $refund->contact_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
