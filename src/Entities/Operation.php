<?php

namespace Source\Entities;

use Source\Entities\PrivateClient;
use Source\Entities\BusienssClient;
use Source\Core\Constants\Operation as OperationConstants;
use Source\Core\Helpers\EntityLoader;

class Operation
{
    /** @var string $date */
    private $date;

    /** @var int $id */
    private $id;

    /** @var string $client_type */
    private $client_type;

    /** @var string $operation_type */
    private $operation_type;

    /** @var float $amount */
    private $amount;

    /** @var string $currency_iso3 */
    private $currency_iso3;

    /** @var int $line */
    private $line;

    //Construct each operation from each CSV line.
    //Validate structure (each field)
    public function __construct($data)
    {
        extract($data);
        $this->date = $date;
        $this->id = $id;
        $this->client_type = $client_type;
        $this->operation_type = $operation_type;
        $this->amount = $amount;
        $this->currency_iso3 = $currency_iso3;

        $this->line = $line;

        $this->validateStructure();
    }

    private function validateStructure(): void
    {
        $this->validateDate();
        $this->validateId();
        $this->validateClientType();
        $this->validateOperationType();
        $this->validateAmount();
        $this->validateCurrency();
    }

    /**
     * @throws \Exception
     */
    private function validateDate(): void
    {
        $format = 'Y-m-d';
        $d = \DateTime::createFromFormat($format, $this->date);
        if (!$d || !$d->format($format) === $this->date) {
            throw new \Exception("The date $this->date has wrong format on line $this->line!" . $GLOBALS['newline']);
        }
    }

    /**
     * @throws \Exception
     */
    private function validateId(): void
    {
        if (!is_numeric($this->id)) {
            throw new \Exception("The client identifier '$this->id' is not numeric on line $this->line!" . $GLOBALS['newline']);
        }
    }

    /**
     * @throws \Exception
     */
    private function validateClientType(): void
    {
        if (!in_array($this->client_type, OperationConstants::ALLOWED_CLIENT_TYPES)) {
            throw new \Exception("Client with identifier '$this->id' has wrong client type '$this->client_type' on line $this->line!" . $GLOBALS['newline']);
        }
    }

    /**
     * @throws \Exception
     */
    private function validateOperationType(): void
    {
        if (!in_array($this->operation_type, OperationConstants::ALLOWED_OPERATION_TYPES)) {
            throw new \Exception("Client with identifier '$this->id' has wrong operation type '$this->operation_type' on line $this->line!" . $GLOBALS['newline']);
        }
    }

    /**
     * @throws \Exception
     */
    private function validateAmount(): void
    {
        if (!is_numeric($this->amount)) {
            throw new \Exception("Client with identifier '$this->id' has wrong amount (not numeric) '$this->amount' on line $this->line!" . $GLOBALS['newline']);
        }
    }

    /**
     * @throws \Exception
     */
    private function validateCurrency(): void
    {
        if (!in_array($this->currency_iso3, OperationConstants::ALLOWED_CURRENCIES)) {
            throw new \Exception("Client with identifier '$this->id' has wrong currency ISO3 '$this->currency_iso3' on line $this->line!" . $GLOBALS['newline']);
        }
    }

    //Getter methods which were not used.
    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getClientType(): string
    {
        return $this->client_type;
    }

    /**
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operation_type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrencyIso3(): string
    {
        return $this->currency_iso3;
    }
    
    //This is the function being called on each CSV line from CSVParser class. It dynamically creates (if needed, with the help of EntityLoader) each
    //client (PrivateClient or BusinessClient) and calls their opearation type dynamically as well.
    public function calculateComission(): void
    {
        $entityLoader = EntityLoader::getInstance();

        $class_name = "Source\Entities\\" . ucfirst($this->client_type) . 'Client';

        $client = $entityLoader->load($class_name, $this->id);
        $client->{$this->operation_type}($this->amount, $this->currency_iso3, $this->date);
    }
}
