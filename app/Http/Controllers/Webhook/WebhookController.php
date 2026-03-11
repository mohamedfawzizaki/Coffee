<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Service\Foodics\WebHookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(private WebHookService $webHookService){}

    /**
     * Display the specified resource.
     */
    public function webhook(Request $request)
    {
        try {

            $this->webHookService->createWebHookOrder($request->getContent());

        } catch (\Throwable $th) {
           Log::channel('webhook_error')->error('Foodics WebHook Error from controller: ' . $th->getMessage());
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }

}
