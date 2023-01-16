<?php

namespace Source\Core\Helpers;

use Source\Core\Constants\Operation;

//just a helper class for Private Clients as we do not want to have a big class. Here I have exported used methods from PrivateClient.
class ClientHelper
{
    /**
     * @param float $amount
     * @param string $currency
     * @param bool $reverse
     * 
     * @return float
     */
    public static function getExchangedAmount($amount, $currency, $reverse = false): float
    {
        if ($reverse) {
            return $currency == 'EUR' ? $amount : $amount * constant('Source\Core\Constants\Operation::' . $currency);
        } else {
            return $currency == 'EUR' ? $amount : $amount / constant('Source\Core\Constants\Operation::' . $currency);
        }
    }

    /**
     * @param array $dates_passed
     * @param string $current_date
     * 
     * @return array
     */
    public static function getDatesWithinAWeek($dates_passed, $current_date): array
    {
        $result = [];

        foreach ($dates_passed as $date_passed) {
            $monday = new \DateTime($current_date);
            $sunday = new \DateTime($current_date);
            $monday->modify('last Monday');
            $sunday->modify('next Sunday');
            $monday_formatted = $monday->format("Y-m-d");
            $sunday_formatted = $sunday->format("Y-m-d");
            if($date_passed >= $monday_formatted && $date_passed <= $sunday_formatted) {
                $result[] = $date_passed;
            } 
        }
        
        return $result;
    }
}