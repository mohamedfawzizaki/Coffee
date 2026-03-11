<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use App\Models\Customer\Customer;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::where('phone', '0123434575')->first();

        if (!$customer) {
            return;
        }

        \App\Models\General\Contact::insert([
            [
                'customer_id' => $customer->id,
                'title' => 'Order Issue',
                'message' => 'I have a problem with my last order, please check it.',
                'seen' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => $customer->id,
                'title' => 'Service Feedback',
                'message' => 'The service at the branch was excellent, thank you.',
                'seen' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => $customer->id,
                'title' => 'Wallet Question',
                'message' => 'How can I use my wallet points when paying?',
                'seen' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}