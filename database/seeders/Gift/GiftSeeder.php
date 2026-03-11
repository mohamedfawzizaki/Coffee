<?php

namespace Database\Seeders\Gift;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Models\Gift\Gift;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderLog;
use App\Models\Product\Product\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = \Faker\Factory::create();


        for ($i = 0; $i < 10; $i++) {

            $sender   = Customer::inRandomOrder()->first();

            $receiver = Customer::inRandomOrder()->first();

            $amount = rand(1, 100);

            Gift::create([
                'sender_id'   => $sender->id,
                'receiver_id' => $receiver->id,
                'amount'      => $amount,
            ]);

            CustomerWallet::create([
                'customer_id' => $sender->id,
                'amount'      => $amount,
                'type'        => 'out',
                'ar_content'  => 'هدية لـ ' . $receiver->name,
                'en_content'  => 'Gift to ' . $receiver->name,
            ]);

            CustomerWallet::create([
                'customer_id' => $receiver->id,
                'amount'      => $amount,
                'type'        => 'in',
                'ar_content'  => 'هدية من ' . $sender->name,
                'en_content'  => 'Gift from ' . $sender->name,
            ]);
        }


        if(Branch::count() > 0){


        foreach (Customer::all() as $customer) {

         for ($i = 0; $i < 10; $i++) {

             $order = Order::create([
                 'customer_id'    => $customer->id,
                 'send_to'        => Customer::inRandomOrder()->first()->id,
                 'total'          => 100,
                 'discount'       => 10,
                 'tax'            => 10,
                 'grand_total'    => 100,
                 'status'         => 'pending',
                 'payment_method' => 'visa',
                 'payment_status' => 'paid',
                 'type'           => 'gift',
                 'payment_id'     => null,
                 'branch_id'      => Branch::inRandomOrder()->first()->id,
                 'lat'            => $faker->latitude(),
                 'lng'            => $faker->longitude(),
             ]);

             for ($j = 0; $j < 3; $j++) {

                $product = Product::inRandomOrder()->first();

                $size = ($product->sizes()->count() > 0) ? $product->sizes()->inRandomOrder()->first() : null;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'size_id'    => ($size) ? $size->id : null,
                    'price'      => $product->price,
                    'quantity'   => 1,
                    'total'      => $product->price,
                ]);
            }


            OrderLog::create([
                'order_id'    => $order->id,
                'customer_id' => $customer->id,
                'ar_content'     => 'تم إنشاء الطلب',
                'en_content'     => 'Order created',
            ]);

            // OrderLog::create([
            //     'order_id'       => $order->id,
            //     'manager_id'     => BranchManager::inRandomOrder()->first()->id,
            //     'ar_content'     => 'تم قبول الطلب',
            //     'en_content'     => 'Order Accepted',
            // ]);
         }

        }

    }

    }
}
