<?php

namespace App\Http\Controllers;

use App\Repositories\OrdersRepository;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    private $smsService;
    private $ordersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->smsService = app(SmsService::class);
        $this->ordersRepository = app(OrdersRepository::class);
    }

    public function notifyWaybill(Request $request)
    {
        $phone = $request->get('phone');
        $waybill = $request->get('waybill');
        $order_id = $request->get('order_id');

        $this->ordersRepository->updateSmsWaybillStatus($order_id);
        return $this->smsService->notifyWaybill($phone, $waybill);
    }
}
