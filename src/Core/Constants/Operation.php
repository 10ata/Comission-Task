<?php

namespace Source\Core\Constants;

class Operation
{
    const CSV_MAPPING = [
        0 => 'date',
        1 => 'id',
        2 => 'client_type',
        3 => 'operation_type',
        4 => 'amount',
        5 => 'currency_iso3',
        6 => 'line'
    ];

    const ALLOWED_CLIENT_TYPES = [
        'private',
        'business'
    ];

    const ALLOWED_OPERATION_TYPES = [
        'withdraw',
        'deposit'
    ];

    const ALLOWED_CURRENCIES = [
        'EUR',
        'USD',
        'JPY'
    ];

    const MAX_ALLOWED_WITHDRAW_OPERATIONS = 3;

    const USD = 1.129031;
    const JPY = 130.869977;
}
