<?php

namespace App\Http\Controllers\Dummy;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use App\Models\Branch\BranchTranslation;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Notifications\Admin\OrderStatusNotification;
use App\Notifications\Customer\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DummyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function orders()
    {

        $customer = Customer::latest()->first();

        $result =  $customer->notify(new OrderStatusNotification('confirmed'));

      dd($result);

        // $include = 'branch,table,table.section,creator,closer,device,driver,customer,customer_address,customer_address.delivery_zone,discount,coupon,tags,promotion,charges,charges.charge,charges.taxes,payments,payments.payment_method,payments.user,gift_card,gift_card.gift_card_product,combos,combos.combo_size,combos.combo_size.combo,combos.products,combos.discount,combos.products.combo_option,combos.products.combo_size,products,products.product,products.product.category,products.discount,products.options,products.options.modifier_option,products.options.taxes,products.taxes,products.timed_events,products.promotion,products.void_reason,products.creator,products.voider,combos.products.product,combos.products.product.category,combos.products.discount,combos.products.options,combos.products.options.modifier_option,combos.products.options.taxes,combos.products.taxes,combos.products.timed_events,combos.products.creator,combos.products.voider,combos.products.promotion,combos.products.void_reason,original_order';


        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('foodics.api_token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://api-sandbox.foodics.com/v5/products', [
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
            // 'filter[created_on]' => '2025-10-06',
            // // 'filter[updated_on]' => '2019-04-30',
            // 'include' => 'branch,customer',
            // 'sort' => [
            //     // 'updated_at',
            //     '-created_at',
            //     // 'reference',
            //     // 'number',
            //     // 'id',
            //     // 'check_number',
            //     // 'business_date'
            // ],
            // 'limit' => 10,
            // 'page' => 1,
        ]);


        $responseData = $response->json();

        dd($responseData);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5MGQ1YTcxOC1lMzBkLTQ5ODYtODY0Ni0wNjdlZDBkMzdkMGUiLCJqdGkiOiJlOTkzYTExYjJiMzY0NjQyM2M3ZWE2OGU1YTgzNWIwNTNhOTg0ODVjYjBlMjcyOTNiODI3ODdiMDEyNmY3YzM2MTMxZTllMjk0MTE4MDNmNCIsImlhdCI6MTc1OTI0NjQwNy43MzYwOTIsIm5iZiI6MTc1OTI0NjQwNy43MzYwOTIsImV4cCI6MTkxNzAxMjgwNy42NDk3NSwic3ViIjoiOTI0M2Y2ZTUtNzQ1My00NTlkLWFhYWMtMzljOTQ3MTc1MmRlIiwic2NvcGVzIjpbImN1c3RvbWVycy5saXN0IiwiZ2VuZXJhbC5yZWFkIiwib3JkZXJzLmdpZnRfY2FyZHMucmVhZCIsImN1c3RvbWVycy5sb3lhbHR5LnJlYWQiLCJvcmRlcnMubGlzdCIsInVzZXJzLnJlYWQiXSwiYnVzaW5lc3MiOiI5MjQzZjZlNS03OGUxLTQ3YTktYTRkMS01MDQzMGQ5YzZjOTIiLCJyZWZlcmVuY2UiOiIxMTQ4MTAifQ.HifIQ9_k2TSeQOv-6fa_1wZFS7C9_ujfUpv7IffJwOAcQ_Pf2qsTR0KjTqr-UefNg5AMuQQZx2WsciYaS2rZ7ygx8yk0TDDWWj2boO6sWHKQ-fbjO-le3OHHD88ewTEWc-8Rbzv0jqoLw6T1VAcLtqxfe919uGfGpWPJG-GfRgVZMackOzYhOco6p7Wb-8ZAT1ab2Vz4bOJMWnrTa7Ol42IJP199_D_-k3dA4OEvboSlXnWwYlqjOwwO-zGkzjfUj3znzChFxyAD9nTjBLtH-xCCmQryrbeuEPmfhvgH2-lIiihYp7MvXwzufZPdlsi7vkWqwnettRVEUO_P5GSAGmKA3eGUR5Y8AKq_H5qTWRD4O9Roz_sfV-rIvjw9XZGf6KVLKgl2SMlmQOJAaRYGgOdtowaNa3bj1MGY57NIUuIK2IjLs1iOZv02uip-W1AvqH9nOEGLxLp1kcayLz31mcDdILPYYwWR5WybmY5MP2mSdaX-udnEOty5ecUWm1FiHnS0SHQHueSceet71Cqg1AsdBpmRpU2xOFKYqXZRl5rsA_rGAQPmy0eJa_26NDyw_TQVuHFwbx1fskAHaeKUeJawI9e4PfJpgmNWpQ8FznvXoJ38qrGBfEjKXmGextI4EproewQRS9k35pGtH1ah0LEX7v1cMrXqAUnpHj3Ph0g',
            'Content-Type' => 'application/json',
        ])->get('https://api.foodics.com/v5/orders', [
            'created_at[gte]' => '2025-06-01T00:00:00Z',
            'per_page' => 20
        ]);

        return $response->json();

        // dd($orders);
    }

    public function branches(){

        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5MGQ1YTcxOC1lMzBkLTQ5ODYtODY0Ni0wNjdlZDBkMzdkMGUiLCJqdGkiOiJlOTkzYTExYjJiMzY0NjQyM2M3ZWE2OGU1YTgzNWIwNTNhOTg0ODVjYjBlMjcyOTNiODI3ODdiMDEyNmY3YzM2MTMxZTllMjk0MTE4MDNmNCIsImlhdCI6MTc1OTI0NjQwNy43MzYwOTIsIm5iZiI6MTc1OTI0NjQwNy43MzYwOTIsImV4cCI6MTkxNzAxMjgwNy42NDk3NSwic3ViIjoiOTI0M2Y2ZTUtNzQ1My00NTlkLWFhYWMtMzljOTQ3MTc1MmRlIiwic2NvcGVzIjpbImN1c3RvbWVycy5saXN0IiwiZ2VuZXJhbC5yZWFkIiwib3JkZXJzLmdpZnRfY2FyZHMucmVhZCIsImN1c3RvbWVycy5sb3lhbHR5LnJlYWQiLCJvcmRlcnMubGlzdCIsInVzZXJzLnJlYWQiXSwiYnVzaW5lc3MiOiI5MjQzZjZlNS03OGUxLTQ3YTktYTRkMS01MDQzMGQ5YzZjOTIiLCJyZWZlcmVuY2UiOiIxMTQ4MTAifQ.HifIQ9_k2TSeQOv-6fa_1wZFS7C9_ujfUpv7IffJwOAcQ_Pf2qsTR0KjTqr-UefNg5AMuQQZx2WsciYaS2rZ7ygx8yk0TDDWWj2boO6sWHKQ-fbjO-le3OHHD88ewTEWc-8Rbzv0jqoLw6T1VAcLtqxfe919uGfGpWPJG-GfRgVZMackOzYhOco6p7Wb-8ZAT1ab2Vz4bOJMWnrTa7Ol42IJP199_D_-k3dA4OEvboSlXnWwYlqjOwwO-zGkzjfUj3znzChFxyAD9nTjBLtH-xCCmQryrbeuEPmfhvgH2-lIiihYp7MvXwzufZPdlsi7vkWqwnettRVEUO_P5GSAGmKA3eGUR5Y8AKq_H5qTWRD4O9Roz_sfV-rIvjw9XZGf6KVLKgl2SMlmQOJAaRYGgOdtowaNa3bj1MGY57NIUuIK2IjLs1iOZv02uip-W1AvqH9nOEGLxLp1kcayLz31mcDdILPYYwWR5WybmY5MP2mSdaX-udnEOty5ecUWm1FiHnS0SHQHueSceet71Cqg1AsdBpmRpU2xOFKYqXZRl5rsA_rGAQPmy0eJa_26NDyw_TQVuHFwbx1fskAHaeKUeJawI9e4PfJpgmNWpQ8FznvXoJ38qrGBfEjKXmGextI4EproewQRS9k35pGtH1ah0LEX7v1cMrXqAUnpHj3Ph0g',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://api.foodics.com/v5/branches');


        $responseData = $response->json();

        $data = $responseData['data'] ?? [];

        foreach($data as $branch){

            $existingBranch = Branch::where('remote_id', $branch['id'])->first();

            if($existingBranch){
                continue;
            }

            $CreatedBranch = Branch::create([
                'remote_id' => $branch['id'],
                'reference' => $branch['reference'],
                'type'      => $branch['type'],
                'lat'       => $branch['latitude'],
                'lng'       => $branch['longitude'],
                'phone'     => $branch['phone'],
                'address'   => $branch['address'],
            ]);

            BranchTranslation::create([
                'branch_id' => $CreatedBranch->id,
                'title' => $branch['name'],
                'locale' => 'ar',
            ]);

            BranchTranslation::create([
                'branch_id' => $CreatedBranch->id,
                'title' => $branch['name_localized'] ?? $branch['name'],
                'locale' => 'en',
            ]);

        }

        return response()->json(['message' => 'Branches created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function users()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5MjdjNzAyNS1hOWJhLTQ4MjgtYTA3MS1lMGQ2NDMzM2EwMDQiLCJqdGkiOiI0MTBmYWZlYzMwMjBhYjM2NGJiM2IwNzBiZDY3NTU2NDdkNThjZmUyZWY5OTI5MTdlMjI4Mjk4NjNhMmYwYWIwYmYyZmZmMDdjNjUwZDkwYyIsImlhdCI6MTY5NTE5ODE5NC4yNzA5NzIsIm5iZiI6MTY5NTE5ODE5NC4yNzA5NzIsImV4cCI6MTg1MzA1MDk5NC4yNTMyMzcsInN1YiI6IiIsInNjb3BlcyI6W10sImJ1c2luZXNzIjoiOTk5ZWU5NGItOWQ2MC00NGI5LTg4NWItMGQ1ZWVlYzFiYzU3IiwicmVmZXJlbmNlIjoiNDE4NDIzIn0.mpcGA5N2iBOuYwShDrpWuAsh4mssxxacZta1ts4iXngsdXh7wtSD0tS-kglICKiUXxjtUZBHiEmLJIw_iXdzo0dvO_d2WoKwMth1-Ldn2d9IetrPzufRjXC51Yetjz3zoXyVTVg397fHS3_7A02eU53X06vbYJk9j026UkZlJlMzrDGCoVAm8nNjP5CMo3-TO4WBRQmb_vciywtIhIBPq-FXNN4KzvGOvfY1KpcJ1u2cxkpm-Axqe-VucGfVbxlzf87MLl8mSQWwXbYargHrJo3ant1WHd2JVqaNs2Xq9Nb8Y8R9fx0O7CVlbkHh5FpXijcJcBgz1yow6AsC3BqYzxHoNTtLwI1OemhBMu6MVFbBYq9oiz9Y_dqjPAyZ-l5570A6C1jqJE50MrEihOp-RXO7476X6_LeeV7bhFz4YRlS53hRRSy8L73f69ENaqiOYqEjOLG3Tjybwt6I3Ms-6dZIwtpVceT0T8Z2DIDkrTc7KUIGbCpDMpGKyM7Wm4NfuY8Gby2F0hl4tkawHVCpoKEygqX7vkUpILgwcEdGoQeIYutzRzs1d0NFmbTKdOPofhWfLrR7dAuWlh4Rce_1P5ipZgRPU-OD_iZzwAPTSsaUxhiry_rfifAJgsQGVs5eFh2CM26HgpVmf05N7TnAqaX4OE0ucgciZGmlbb7H8fI',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://api.foodics.dev/users', [
            // 'filter[number]' => '',
            // 'filter[id]' => '',
            // 'filter[name]' => '',
            // 'filter[email]' => '',
            // 'filter[phone]' => '',
            // 'filter[email_verified]' => '',
            // 'filter[branches.id]' => '',
            // 'filter[roles.id]' => '',
            // 'filter[tags.id]' => '',
            // 'filter[updated_after]' => '2019-04-22  00:11:41',
            // 'filter[created_on]' => '2019-04-22',
            // 'filter[updated_on]' => '2019-04-22',
            // 'filter[deleted_on]' => '2019-04-22',
            // 'filter[has_app_access]' => 'true',
            // 'filter[has_console_access]' => 'true',
            // 'filter[has_roles]' => 'true',
            // 'filter[has_branches]' => 'true',
            // 'filter[include_owner]' => 'true',
            // 'filter[is_deleted]' => 'true',
            'include' => 'tags,branches,roles,notifications',
            'sort' => [
                // 'updated_at',
                 'created_at',
                //   'name',
                //    'number',
                //     'email',
                //      'phone'
                    ],
            'page' => 1,
        ]);

        return $response->body();
    }


   public function store(Request $request)
   {

   $secret = env('FOODICS_WEBHOOK_SECRET');

   $signature = $request->header('X-Foodics-Hmac-SHA256');

   $computedSignature = base64_encode(hash_hmac('sha256', $request->getContent(), $secret, true));

   if (!hash_equals($signature, $computedSignature)) {
       return response()->json(['error' => 'Invalid signature'], 403);
   }

       Log::info('Valid Foodics Webhook:', $request->all());

       $event = $request->input('type'); // Example: "order.created"

       $data  = $request->input('data');  // Order details

       if ($event === 'order.created') {

           // Handle order creation
           // Example: Save order details in DB

       } elseif ($event === 'order.updated') {

           // Handle order updates
       }

       return response()->json(['message' => 'Webhook received']);

   }

    /**
     * Display the specified resource.
     */
    public function notification ()
    {
        $user = Customer::first();

        $order = Order::first();

        $user->notify(new NewOrderNotification($order));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
