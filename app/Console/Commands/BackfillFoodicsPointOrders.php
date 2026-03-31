<?php

namespace App\Console\Commands;

use App\Models\Customer\CustomerPoint;
use App\Models\Foodics\Foodics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BackfillFoodicsPointOrders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'points:backfill-foodics
                            {--dry-run : Show what would change without persisting}';

    /**
     * The console command description.
     */
    protected $description = 'Re-link existing CustomerPoint records that came from Foodics but have order_id = null';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        $this->info($dryRun ? '[DRY RUN] No changes will be saved.' : 'Starting backfill...');

        // Find all Foodics point records that have no order_id
        $nullPoints = CustomerPoint::whereNull('order_id')
            ->where('en_content', 'Points Added From Foodics Orders')
            ->get();

        $this->info("Found {$nullPoints->count()} CustomerPoint record(s) to process.");

        $fixed   = 0;
        $skipped = 0;

        foreach ($nullPoints as $point) {
            // Find all Foodics orders for this customer that are already claimed by them
            $foodicsOrders = Foodics::where('customer_id', $point->customer_id)->get();

            if ($foodicsOrders->isEmpty()) {
                $this->warn("  [SKIP] CustomerPoint #{$point->id} — no Foodics orders found for customer #{$point->customer_id}");
                $skipped++;
                continue;
            }

            if ($foodicsOrders->count() === 1) {
                // Simple case: link to the single Foodics order
                $foodicsOrder = $foodicsOrders->first();
                $this->line("  [FIX] CustomerPoint #{$point->id} → foodics #{$foodicsOrder->id}");

                if (!$dryRun) {
                    $point->update([
                        'order_id'   => $foodicsOrder->id,
                        'order_type' => 'foodics',
                    ]);
                }
                $fixed++;

            } else {
                // Multiple Foodics orders: split into N separate CustomerPoint records
                $this->line("  [SPLIT] CustomerPoint #{$point->id} → {$foodicsOrders->count()} Foodics orders for customer #{$point->customer_id}");

                if (!$dryRun) {
                    DB::transaction(function () use ($point, $foodicsOrders) {
                        $first = true;
                        foreach ($foodicsOrders as $foodicsOrder) {
                            if ($first) {
                                // Reuse the existing record for the first order
                                $point->update([
                                    'order_id'   => $foodicsOrder->id,
                                    'order_type' => 'foodics',
                                    'amount'     => $foodicsOrder->points,
                                ]);
                                $first = false;
                            } else {
                                // Create new records for remaining orders
                                CustomerPoint::create([
                                    'customer_id' => $point->customer_id,
                                    'order_id'    => $foodicsOrder->id,
                                    'order_type'  => 'foodics',
                                    'amount'      => $foodicsOrder->points,
                                    'type'        => 'in',
                                    'ar_content'  => $point->ar_content,
                                    'en_content'  => $point->en_content,
                                ]);
                            }
                        }
                    });
                }
                $fixed++;
            }
        }

        $this->info("Done. Fixed: {$fixed} | Skipped: {$skipped}");
        Log::info("points:backfill-foodics completed. Fixed: {$fixed}, Skipped: {$skipped}, DryRun: " . ($dryRun ? 'yes' : 'no'));

        return Command::SUCCESS;
    }
}
