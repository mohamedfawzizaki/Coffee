<?php

namespace App\Services;

use App\Models\Order\Order;
use App\Notifications\Cashier\OrderStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderStatusService
{
    /**
     * Update order status with performance optimization
     */
    public function updateOrderStatus(string $orderId, string $newStatus, string $currentStatus = null): array
    {
        try {
            DB::beginTransaction();

            // Optimized query with loading only required relationship
            $order = Order::with('customer:id,device_token')->find($orderId);

            if (!$order) {
                return ['success' => false, 'message' => 'Order not found'];
            }

            // Check current status if provided
            if ($currentStatus && $order->status !== $currentStatus) {
                return ['success' => false, 'message' => "Order is not {$currentStatus}"];
            }

            // Update status using update method instead of save for better performance
            $order->update(['status' => $newStatus]);

            // Send notification asynchronously
            if ($order->customer) {
                $order->customer->notify(new OrderStatusNotification($order, $newStatus));
            }

            DB::commit();

            Log::info("Order status updated successfully", [
                'order_id' => $orderId,
                'old_status' => $currentStatus,
                'new_status' => $newStatus
            ]);

            return ['success' => true, 'message' => "Order {$newStatus}"];

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Failed to update order status", [
                'order_id' => $orderId,
                'status' => $newStatus,
                'error' => $e->getMessage()
            ]);

            return ['success' => false, 'message' => 'Failed to update order status'];
        }
    }

    /**
     * Confirm order
     */
    public function confirmOrder(string $orderId): array
    {
        return $this->updateOrderStatus($orderId, 'processing', 'pending');
    }

    /**
     * Ready order
     */
    public function readyOrder(string $orderId): array
    {
        return $this->updateOrderStatus($orderId, 'ready', 'processing');
    }

    /**
     * Complete order
     */
    public function completeOrder(string $orderId): array
    {
        return $this->updateOrderStatus($orderId, 'completed', 'ready');
    }

    /**
     * Cancel order
     */
    public function cancelOrder(string $orderId): array
    {
        return $this->updateOrderStatus($orderId, 'cancelled', 'pending');
    }
}
