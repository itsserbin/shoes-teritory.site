<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    private $smsService;

    public function __construct()
    {
        parent::__construct();
        $this->smsService = app(SmsService::class);
    }

    public function notifyWaybill(Request $request)
    {
        $phone = $request->get('phone');
        $waybill = $request->get('waybill');

        return $this->smsService->notifyWaybill($phone, $waybill);
    }
}
