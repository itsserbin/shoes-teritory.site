<?php

namespace App\Console\Commands;

use App\Models\Enum\OrderStatus;
use App\Models\Orders;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ApiNovaPoshtaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api_nova_poshta:order_integration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Orders::where([
            ['waybill', '!=', null],
            ['status', '!=', OrderStatus::STATUS_RETURN],
            ['status', '!=', OrderStatus::STATUS_CANCELED],
            ['status', '!=', OrderStatus::STATUS_DONE],
            ['status', '!=', OrderStatus::STATUS_AWAITING_PREPAYMENT],
        ])->select('id', 'status', 'waybill')->get();

        foreach ($orders as $item) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
                CURLOPT_RETURNTRANSFER => True,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'apiKey' => 'ef9ad9f085a4555623f1513fd91a5892',
                    'modelName' => 'TrackingDocument',
                    'calledMethod' => 'getStatusDocuments',
                    'methodProperties' => [
                        'Documents' => [
                            ['DocumentNumber' => $item->waybill],
                        ]
                    ]
                ]),
                CURLOPT_HTTPHEADER => array("content-type: application/json",),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $result = json_decode($response, true);
                if (isset($result['data'][0])) {
                    if ($result['data'][0]['StatusCode'] === '1') {
                        $item->status = OrderStatus::STATUS_AWAITING_DISPATCH;
                    } elseif (in_array($result['data'][0]['StatusCode'], ['102', '103', '108'], true)) {
                        $item->status = OrderStatus::STATUS_RETURN;
                    } elseif (in_array($result['data'][0]['StatusCode'], ['7', '8'], true)) {
                        $item->status = OrderStatus::STATUS_AT_THE_POST_OFFICE;
                    } elseif (in_array($result['data'][0]['StatusCode'], ['5', '6', '101'], true)) {
                        $item->status = OrderStatus::STATUS_ON_THE_ROAD;
                    } elseif (in_array($result['data'][0]['StatusCode'], ['9', '10', '11'], true)) {
                        $item->status = OrderStatus::STATUS_DONE;
                    }
                } else {
                    Log::error('id: ' . $item->id . "\n" . 'waybill:' . $item->waybill);
                }

                $item->update();
            }
        }
    }
}
