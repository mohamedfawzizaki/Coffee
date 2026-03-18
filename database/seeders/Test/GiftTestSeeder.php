<?php

namespace Database\Seeders\Test;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Gift\Gift;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Gift\GiftOrderItem;
use App\Models\Order\Order;
use App\Models\Product\Product\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GiftTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Ensure we have enough customers
        if (Customer::count() < 10) {
            for ($i = 0; $i < 10; $i++) {
                Customer::create([
                    'name'     => $faker->name,
                    'phone'    => $faker->unique()->phoneNumber,
                    'email'    => $faker->unique()->safeEmail,
                    'wallet'   => rand(500, 2000),
                    'points'   => rand(100, 1000),
                    'status'   => 1,
                    'verified' => 1,
                ]);
            }
        }

        $customers = Customer::all();
        $products  = Product::all();
        $branches  = Branch::all();

        if ($products->isEmpty() || $branches->isEmpty()) {
            $this->command->error('No products or branches found. Please seed them first.');
            return;
        }

        // Seed Product Gifts (GiftOrder)
        for ($i = 0; $i < 15; $i++) {
            $sender   = $customers->random();
            $receiver = $customers->where('id', '!=', $sender->id)->random();
            $branch   = $branches->random();

            $giftOrder = GiftOrder::create([
                'customer_id'    => $sender->id,
                'send_to'        => $receiver->id,
                'branch_id'      => $branch->id,
                'total'          => 0,
                'discount'       => 0,
                'tax'            => 0,
                'grand_total'    => 0,
                'status'         => 'completed',
                'payment_method' => 'wallet',
                'payment_status' => 'paid',
                'title'          => 'Gift for ' . $receiver->name,
                'message'        => $faker->sentence,
            ]);

            $total = 0;
            $itemsCount = rand(1, 3);
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $size = $product->sizes->first();
                $price = $size ? $size->price : $product->price;

                GiftOrderItem::create([
                    'gift_order_id' => $giftOrder->id,
                    'product_id'    => $product->id,
                    'size_id'       => $size ? $size->id : null,
                    'price'         => $price,
                    'quantity'      => 1,
                    'total'         => $price,
                ]);
                $total += $price;
            }

            $giftOrder->update([
                'total'       => $total,
                'grand_total' => $total,
            ]);
        }

        // Seed Gift Cards (Gift / Transfers)
        for ($i = 0; $i < 15; $i++) {
            $sender   = $customers->random();
            $receiver = $customers->where('id', '!=', $sender->id)->random();
            $amount   = rand(10, 200);

            Gift::create([
                'sender_id'   => $sender->id,
                'receiver_id' => $receiver->id,
                'amount'      => $amount,
                'message'     => $faker->sentence,
            ]);
        }

        // Seed Regular Orders
        for ($i = 0; $i < 10; $i++) {
            $customer = $customers->random();
            $branch   = $branches->random();
            $order = Order::create([
                'customer_id'    => $customer->id,
                'branch_id'      => $branch->id,
                'total'          => rand(50, 200),
                'discount'       => 0,
                'tax'            => 0,
                'grand_total'    => rand(50, 200),
                'status'         => 'pending',
                'payment_method' => 'cash',
                'type'           => 'order',
            ]);
        }

        // Seed Point Orders
        for ($i = 0; $i < 3; $i++) {
            $customer = $customers->random();
            $branch   = $branches->random();
            $pointProducts = $products->where('points', '>', 0);
            $product  = $pointProducts->isNotEmpty() ? $pointProducts->random() : $products->random();
            
            $order = Order::create([
                'customer_id'    => $customer->id,
                'branch_id'      => $branch->id,
                'product_id'     => $product->id,
                'points'         => $product->points ?? rand(50, 100),
                'total'          => $product->points ?? rand(50, 100),
                'discount'       => 0,
                'tax'            => 0,
                'grand_total'    => $product->points ?? rand(50, 100),
                'status'         => 'pending',
                'payment_method' => 'points',
                'type'           => 'point',
            ]);
        }

        $this->command->info('Gift and Order functionality seeded successfully!');
    }
}
