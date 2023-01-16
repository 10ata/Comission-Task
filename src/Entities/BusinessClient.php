<?php

namespace Source\Entities;

use Source\Entities\AbstractClient;

//BusinessClient class for business clients. Nothing specific here as their functionality is pretty basic.
class BusinessClient extends AbstractClient
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    /**
     * @param float $amount
     * @param string $currency
     * @param string|null $date
     */
    public function withdraw($amount, $currency, $date = null): void
    {
        echo $this->roundNumber(0.5 / 100 * $amount) . $GLOBALS['newline'];
    }
}
