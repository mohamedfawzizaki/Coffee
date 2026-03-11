<?php

namespace Database\Seeders\Order;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderLog;
use App\Models\Product\Product\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        if(Branch::count() == 0) {
            $this->command->error('No branches found. Please run BranchSeeder first.');
            return;
        }

        if(Customer::count() == 0) {
            $this->command->error('No customers found. Please run CustomerSeeder first.');
            return;
        }

        if(Product::count() == 0) {
            $this->command->error('No products found. Please run ProductSeeder first.');
            return;
        }

        $this->command->info('Starting Order Seeder...');

        foreach (Customer::all() as $customer) {
            
            // Create orders with different dates across the last 12 months
            for ($i = 0; $i < 30; $i++) {
                
                // Generate random date within the last year
                $randomDate = Carbon::now()->subMonths(rand(0, 11))->subDays(rand(0, 30));
                
                // Create more orders in recent months to see variation
                if ($i < 20) {
                    // More orders in last 3 months
                    $randomDate = Carbon::now()->subMonths(rand(0, 2))->subDays(rand(0, 28));
                }
                
                // Generate realistic totals
                $subtotal = $faker->numberBetween(50, 500);
                $discount = $faker->numberBetween(0, 50);
                $tax = round($subtotal * 0.14, 2); // 14% tax
                $grandTotal = $subtotal - $discount + $tax;
                
                $order = Order::create([
                    'customer_id'     => $customer->id,
                    'total'           => $subtotal,
                    'discount'        => $discount,
                    'tax'             => $tax,
                    'grand_total'     => $grandTotal,
                    'status'          => $faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                    'payment_method'  => $faker->randomElement(['visa', 'cash', 'mada', 'mastercard']),
                    'payment_status'  => $faker->randomElement(['paid', 'unpaid', 'refunded']),
                    'payment_id'      => $faker->uuid(),
                    'branch_id'       => Branch::inRandomOrder()->first()->id,
                    'lat'             => $faker->latitude(),
                    'lng'             => $faker->longitude(),
                    'created_at'      => $randomDate,
                    'updated_at'      => $randomDate,
                ]);

                // Add 1-5 items per order
                $numberOfItems = rand(1, 5);
                for ($j = 0; $j < $numberOfItems; $j++) {
                    
                    $product = Product::inRandomOrder()->first();
                    
                    $size = ($product->sizes()->count() > 0) 
                        ? $product->sizes()->inRandomOrder()->first() 
                        : null;
                    
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    
                    OrderItem::create([
                        'order_id'    => $order->id,
                        'product_id'  => $product->id,
                        'size_id'     => ($size) ? $size->id : null,
                        'price'       => $price,
                        'quantity'    => $quantity,
                        'total'       => $price * $quantity,
                        'created_at'  => $randomDate,
                        'updated_at'  => $randomDate,
                    ]);
                }

                // Create order logs with appropriate dates
                OrderLog::create([
                    'order_id'     => $order->id,
                    'customer_id'  => $customer->id,
                    'ar_content'   => 'تم إنشاء الطلب',
                    'en_content'   => 'Order created',
                    'created_at'   => $randomDate,
                    'updated_at'   => $randomDate,
                ]);

                // Sometimes add status change logs
                if ($order->status != 'pending') {
                    OrderLog::create([
                        'order_id'     => $order->id,
                        'customer_id'  => $customer->id,
                        'ar_content'   => 'تم تغيير حالة الطلب إلى ' . $this->getArabicStatus($order->status),
                        'en_content'   => 'Order status changed to ' . $order->status,
                        'created_at'   => $randomDate->copy()->addHours(rand(1, 24)),
                        'updated_at'   => $randomDate->copy()->addHours(rand(1, 24)),
                    ]);
                }
            }
            
            $this->command->info("Created orders for customer: {$customer->id}");
        }

        $this->command->info('Order Seeder completed successfully!');
        $this->command->info('Total orders created: ' . Order::count());
    }

    /**
     * Get Arabic status translation
     */
    private function getArabicStatus($status): string
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $status
        };
    }
}