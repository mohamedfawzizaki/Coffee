<?php

namespace App\Observers;

use App\Models\Customer\Customer;
use App\Models\Customer\Point;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        if ($customer->points > 0) {
            Point::create([
                'customer_id' => $customer->id,
                'point' => $customer->points,
                'status' => true,
            ]);
        }
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        if ($customer->wasChanged('points')) {

            Point::updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'point' => $customer->points,
                    'status' => true
                ]
            );
        }
    }
} 







