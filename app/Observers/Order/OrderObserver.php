<?php

namespace App\Observers\Order;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\CustomerCard\CustomerCard;
use App\Models\Order\Order;
use App\Notifications\Customer\NewOrderNotification;
use App\Notifications\Customer\OrderStatusNotification; // Added this import
use App\Traits\QR;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    use QR;
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {

        $customer = Customer::find($order->customer_id);

        if (!$customer) {
            return;
        }

        $customerCard = CustomerCard::find($customer->card_id);

        if ($customerCard) {

            $customer_orders_count = Order::where('customer_id', $order->customer_id)
                ->where('created_at', '>=', now()->subDays(30))
                ->where('status', '!=', 'cancelled')
                ->where('type', '!=', 'point')
                ->count();

            $card = CustomerCard::where('orders_count', '<=', $customer_orders_count)
                ->orderBy('orders_count', 'desc')
                ->first();

            if ($card && $card->id !== $customerCard->id) {

                $customer->update([
                    'card_id' => $card->id,
                ]);
            }
        }

        // $customer->notify(new NewOrderNotification($order));

        $branch = Branch::find($order->branch_id);

        if ($branch) {

            $managers = $branch->posManagers;

            foreach ($managers as $manager) {
                $manager->notify(new NewOrderNotification($order));
            }
        }

        $sendTo = Customer::find($order->send_to);

        if ($sendTo) {
            $sendTo->notify(new NewOrderNotification($order));
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $status   = $order->status;
        $customer = null;

        // Only notify on meaningful status changes
        $notifiableStatuses = ['preparing', 'prepared', 'ready', 'cancelled'];

        if ($order->isDirty('status') && in_array($status, $notifiableStatuses)) {

            // Notify the original customer
            $customer = Customer::find($order->customer_id);
            if ($customer) {
                $customer->notify(new OrderStatusNotification($order, $status));
            }

            // Notify the gift recipient (send_to) if different from the original customer
            $sendTo = Customer::find($order->send_to);
            if ($sendTo && optional($customer)->id !== $sendTo->id) {
                $sendTo->notify(new OrderStatusNotification($order, $status));
            }
        }

        // Loyalty card recalculation on cancellation
        if ($status === 'cancelled') {
            $customer = $customer ?? Customer::find($order->customer_id);

            if ($customer) {
                $customerCard = CustomerCard::find($customer->card_id);

                if ($customerCard) {

                    $customer_orders_count = Order::where('customer_id', $order->customer_id)
                        ->where('created_at', '>=', now()->subDays(30))
                        ->where('status', '!=', 'cancelled')
                        ->where('type', '!=', 'point')
                        ->count();

                    $card = CustomerCard::where('orders_count', '<=', $customer_orders_count)
                        ->orderBy('orders_count', 'desc')
                        ->first();

                    if ($card && $card->id !== $customerCard->id) {
                        $customer->update([
                            'card_id' => $card->id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
