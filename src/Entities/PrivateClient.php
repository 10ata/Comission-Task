<?php

namespace Source\Entities;

use Source\Entities\AbstractClient;
use Source\Core\Helpers\ClientHelper;
use Source\Core\Constants\Operation;

//PrivateClient class for private clients.
//Here we save the free amount (1000), num of withdraws per week, the dates history if his opeations per a private client
class PrivateClient extends AbstractClient
{
    /**
     * @var float $free_amount
     */
    private $free_amount = 1000.00;

    /**
     * @var array $dates
     */
    private $dates = [];

    /**
     * @var int $free_amount
     */
    private $num_draws = 0;

    public function __construct($id)
    {
        parent::__construct($id);
    }

    /**
     * @param float $amount
     * @param string $currency
     * @param string|null $date
     */
    public function withdraw($amount, $currency, $date): void
    {
        //calculate week here and reset num_draws if needed
        $charge = $this->checkNumDraws($date);

        if ($this->free_amount > 0)
        {
            $this->free_amount -= ClientHelper::getExchangedAmount($amount, $currency);

            if ($this->free_amount > 0)
            {
                $charge = false;
            } else {
                $charge = true;
                $amount = ClientHelper::getExchangedAmount($this->free_amount * -1, $currency, true);
            }

        } else {
            $charge = true;
        }

        $this->printWithdraw($charge ? $amount : 0);
        
    }

    /**
     * @param float $amount
     */
    private function printWithdraw($amount): void
    {
        echo $this->roundNumber(0.3 / 100 * $amount) . $GLOBALS['newline'];
    }

    /**
     * @param string $date
     * 
     * @return bool
     */
    public function checkNumDraws($date): bool
    {
        $dates = ClientHelper::getDatesWithinAWeek($this->dates, $date);
        $this->dates[] = $date;
        if (count($dates) > Operation::MAX_ALLOWED_WITHDRAW_OPERATIONS)
        {
            return false;
        }
        else if (count($dates) == 0) {
            
            $this->num_draws = 1;
            $this->free_amount = 1000;
        }
        else {
            $this->num_draws ++;
        }
        return true;
    }
}
