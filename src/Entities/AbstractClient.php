<?php

namespace Source\Entities;

//Main abstract class of a client with defined generic props and methods.
abstract class AbstractClient
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @param int $id
     */
    protected function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    abstract public function withdraw($amount, $currency, $date);

    /**
     * @param float $deposit
     */
    public function deposit($amount): void
    {
        echo $this->roundNumber(0.03 / 100 * $amount) . $GLOBALS['newline'];
    }

    /**
     * @param float $number
     * 
     * @return string
     */
    public function roundNumber($number): string
    {
        return number_format(ceil($number*100)/100, 2);
    }
    
}
