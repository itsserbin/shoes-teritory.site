<?php

namespace App\Models\Enum;

class ClientSubStatus
{
    const EXPERIENCED_STATUS_SATISFIED = 'Остались довольны';
    const EXPERIENCED_STATUS_ASKED_FOR_AN_EXCHANGE = 'Попросили обмен';
    const EXPERIENCED_STATUS_NO_RESPONSE = 'Не ответили';
    const EXPERIENCED_STATUS_NOT_SATISFIED = 'Не довольны';
    const EXPERIENCED_STATUS_IN_PROGRESS = 'В процессе';

    const RETURN_STATUS_AGREED = 'Согласились';
    const RETURN_STATUS_REFUSED = 'Отказались';
    const RETURN_STATUS_DIDNT_GET_IN_TOUCH = 'Не вышли на связь';
    const RETURN_STATUS_NEW = 'Новый';
}
