<?php

namespace App\Providers;

use App\Models\Customer\Customer;
use App\Models\General\Setting;
use App\Models\Order\Order;
use App\Observers\CustomerObserver;
use App\Observers\Order\OrderObserver;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind enhanced FCM service
        $this->app->bind('fcm', function () {
            return new \App\Services\FcmService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set PHP timezone to match Laravel app timezone
        date_default_timezone_set(config('app.timezone'));

        // Set Carbon default timezone to match Laravel app timezone
        Carbon::setLocale(config('app.locale'));

        // Ensure API/JSON date serialization returns DB-like datetime string
        // (no ISO8601 "Z", and no forced timezone conversion here)
        Carbon::serializeUsing(function (CarbonInterface $carbon): string {
            return $carbon->format('Y-m-d H:i:s');
        });

        // Avoid touching the DB during Artisan/CLI commands (e.g. `storage:link`)
        // This prevents boot-time failures when the DB isn't available.
        if (!$this->app->runningInConsole()) {
            try {
                if (Schema::hasTable('settings')) {
                    $setting = Setting::first() ?? new Setting();
                    view()->share('setting', $setting);
                }
            } catch (\Throwable $e) {
                // Intentionally ignore: DB may be down during bootstrap
            }

            view()->share('locales', config('translatable.locales'));
        }


        Order::observe(OrderObserver::class);
        Customer::observe(CustomerObserver::class);
    }
}
