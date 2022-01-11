<?php

namespace App\Services;

use Daaner\TurboSMS\Facades\TurboSMS;

class SmsService
{
    public function notifyWaybill($phone, $waybill)
    {
        return TurboSMS::sendMessages($phone,
            'Номер Вашої накладної: ' . $waybill . "\n\n" .'З любовʼю, dabango.store ❤️',
            'sms'
        );
    }
}
