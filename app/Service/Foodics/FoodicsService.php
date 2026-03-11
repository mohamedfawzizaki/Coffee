<?php

namespace App\Service\Foodics;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class FoodicsService
{
    public function getOrders()
    {

        // $include = 'branch,table,table.section,creator,closer,device,driver,customer,customer_address,customer_address.delivery_zone,discount,coupon,tags,promotion,charges,charges.charge,charges.taxes,payments,payments.payment_method,payments.user,gift_card,gift_card.gift_card_product,combos,combos.combo_size,combos.combo_size.combo,combos.products,combos.discount,combos.products.combo_option,combos.products.combo_size,products,products.product,products.product.category,products.discount,products.options,products.options.modifier_option,products.options.taxes,products.taxes,products.timed_events,products.promotion,products.void_reason,products.creator,products.voider,combos.products.product,combos.products.product.category,combos.products.discount,combos.products.options,combos.products.options.modifier_option,combos.products.options.taxes,combos.products.taxes,combos.products.timed_events,combos.products.creator,combos.products.voider,combos.products.promotion,combos.products.void_reason,original_order';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('foodics.api_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('foodics.api_url') . '/v5/orders', [
            // 'filter[business_date]' => '',
            // 'filter[id]' => '',
            // 'filter[reference]' => '',
            // 'filter[number]' => '',
            // 'filter[app_id]' => '',
            // 'filter[branch_id]' => '',
            // 'filter[device_id]' => '',
            // 'filter[table_id]' => '',
            // 'filter[coupon_id]' => '',
            // 'filter[creator_id]' => '',
            // 'filter[closer_id]' => '',
            // 'filter[driver_id]' => '',
            // 'filter[customer_id]' => '',
            // 'filter[discount_id]' => '',
            // 'filter[tags.id]' => '',
            // 'filter[original_order_id]' => '',
            // 'filter[is_ahead]' => '',
            // 'filter[type]' => '',
            // 'filter[source]' => '',
            // 'filter[status]' => '',
            // 'filter[check_number]' => '',
            // 'filter[customer_notes]' => '',
            // 'filter[kitchen_notes]' => '',
            // 'filter[delivery_status]' => '',
            // 'filter[is_ahead]' => 'true',
            // 'filter[has_tags]' => 'true',
            // 'filter[has_terminal_payment]' => 'true',
            // 'filter[updated_after]' => '2019-04-22  00:11:41',
            // 'filter[business_date_after]' => '2019-04-01',
            // 'filter[business_date_before]' => '2019-04-30',
            // 'filter[due_on]' => '2019-04-30',
            'filter[created_on]' => Carbon::now()->format('Y-m-d'),
            // 'filter[updated_on]' => '2019-04-30',
            'include' => 'branch,customer',
            'sort' => [
                // 'updated_at',
                '-created_at',
                // 'reference',
                // 'number',
                // 'id',
                // 'check_number',
                // 'business_date'
            ],
            'per_page' => 5
        ]);


        $responseData = $response->json();

        dd($responseData);
    }

    public function getBranches()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('foodics.api_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('foodics.api_url') . '/v5/branches');

        $responseData = $response->json();

       return $responseData;
    }
}
