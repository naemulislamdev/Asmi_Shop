<?php

namespace App\Console\Commands;

use App\Helpers\PhoneHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillCustomerPhoneNormalized extends Command
{
    protected $signature = 'orders:backfill-normalized-phone {--chunk=1000}';

    protected $description = 'Backfill orders.customer_phone_normalized from customer_phone (chunked, idempotent).';

    public function handle(): int
    {
        $chunk = (int) $this->option('chunk');
        if ($chunk < 1) {
            $chunk = 1000;
        }
        $count = 0;

        // Raw query builder: no model events, no updated_at churn.
        DB::table('orders')->select('id', 'customer_phone')->orderBy('id')
            ->chunkById($chunk, function ($orders) use (&$count) {
                foreach ($orders as $order) {
                    DB::table('orders')->where('id', $order->id)->update([
                        'customer_phone_normalized' => PhoneHelper::normalize($order->customer_phone),
                    ]);
                    $count++;
                }
                $this->info("Processed {$count}...");
            });

        $this->info("Done. Backfilled {$count} orders.");

        return self::SUCCESS;
    }
}
