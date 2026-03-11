<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use App\Models\Customer\Customer;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::where('phone', '0123434575')->first();

        if (!$customer) {
            return;
        }

        \App\Models\Finance\Payment::create([
            'customer_id' => $customer->id,
            'amount' => 150.50,
            'wallet_amount' => 0,
            'visa_amount' => 150.50,
            'status' => 'paid',
            'type' => 'product',
            'payment_method' => 'visa',
            'place' => 'Cairo Branch',
            'note' => 'Coffee order',
        ]);

        \App\Models\Finance\Payment::create([
            'customer_id' => $customer->id,
            'amount' => 75.00,
            'wallet_amount' => 75.00,
            'visa_amount' => 0,
            'status' => 'paid',
            'type' => 'service',
            'payment_method' => 'wallet',
            'place' => 'Drive Thru',
            'note' => 'Car wash service',
            'car_details' => 'Toyota Corolla',
        ]);

        \App\Models\Finance\Payment::create([
            'customer_id' => $customer->id,
            'amount' => 220.00,
            'wallet_amount' => 100.00,
            'visa_amount' => 120.00,
            'status' => 'paid',
            'type' => 'product',
            'payment_method' => 'noon',
            'place' => 'Online',
            'note' => 'Online order',
        ]);
    }
}