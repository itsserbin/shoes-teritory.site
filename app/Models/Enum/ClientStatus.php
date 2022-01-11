<?php

namespace App\Models\Enum;

class ClientStatus
{
    const NEW_STATUS = 'Новый';
    const EXPERIENCED_STATUS = 'Раннее закупался';
    const TOP_STATUS = 'ТОПчик';
    const RETURN_STATUS = 'Возврат';
    const BLACK_LIST_STATUS = 'ЧС';
}
