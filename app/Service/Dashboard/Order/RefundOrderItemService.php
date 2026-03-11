<?php

namespace App\Service\Dashboard\Order;

use App\Models\Customer\CustomerPoint;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use Illuminate\Support\Facades\DB;

class RefundOrderItemService
{
    /**
     * Refund a single order item.
     *
     * - Marks the item as refunded.
     * - Subtracts the item total from the order totals.
     * - Deducts the proportional customer points.
     *
     * @return array ['success' => bool, 'message' => string]
     */
    public function refund(Order $order, OrderItem $item): array
    {
        if ($item->is_refunded) {
            return ['success' => false, 'message' => __('Item already refunded')];
        }

        if ($item->order_id !== $order->id) {
            return ['success' => false, 'message' => __('Item does not belong to this order')];
        }

        DB::transaction(function () use ($order, $item) {

            // 1. Calculate points to deduct proportionally
            $pointsToDeduct = $this->calculateRefundPoints($order, $item);

            // 2. Mark item as refunded
            $item->update([
                'is_refunded' => true,
                'refunded_at' => now(),
            ]);

            // 3. Adjust order totals
            $newTotal      = max(0, $order->total - $item->total);
            $newGrandTotal = max(0, $order->grand_total - $item->total);

            $order->update([
                'total'       => $newTotal,
                'grand_total' => $newGrandTotal,
            ]);

            // 4. Deduct points from customer if they had any
            if ($pointsToDeduct > 0) {
                $customer = $order->customer;

                CustomerPoint::create([
                    'customer_id' => $customer->id,
                    'order_id'    => $order->id,
                    'amount'      => round($pointsToDeduct),
                    'ar_content'  => 'خصم نقاط بسبب إرجاع منتج من الطلب #' . $order->id,
                    'en_content'  => 'Points deducted due to product refund in order #' . $order->id,
                    'type'        => 'out',
                ]);

                $customer->update([
                    'points' => max(0, $customer->points - round($pointsToDeduct)),
                ]);
            }
        });

        return ['success' => true, 'message' => __('Item refunded successfully')];
    }

    /**
     * Calculate the proportional points to deduct for a refunded item.
     */
    private function calculateRefundPoints(Order $order, OrderItem $item): float
    {
        // Find the original customer points earned for this order
        $pointRecord = $order->customer
            ->pointsRecords()
            ->where('order_id', $order->id)
            ->where('type', 'in')
            ->latest()
            ->first();

        if (!$pointRecord || $pointRecord->amount <= 0) {
            return 0;
        }

        // Sum of ALL items' totals (this method is called before marking refunded,
        // so this represents the original gross total for all items)
        $originalTotal = $order->items()->sum('total');

        if ($originalTotal <= 0) {
            return 0;
        }

        // Proportional points = (item_total / gross_items_total) * total_points_earned
        return ($item->total / $originalTotal) * $pointRecord->amount;
    }
}
