<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetExpiredFlashDeals extends Command
{
   protected $signature   = 'flash:reset';
    protected $description = 'Reset discount to 0 for all expired flash deal products';

    public function handle(): void
    {
        $today = Carbon::today()->toDateString(); // "2024-01-15"

        $updated = Product::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('end_date', '<', $today)
            ->where('discount', '>', 0)
            ->update([
                'discount'   => 0,
                'discount_type' => null,
                'start_date' => null,
                'end_date'   => null,
            ]);

        $this->info("Reset complete. {$updated} product(s) updated.");
    }
}
