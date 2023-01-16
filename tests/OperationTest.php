<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Source\Entities\Operation;

final class OperationTest extends \PHPUnit\Framework\TestCase {
    
    public function setUp(): void
    {
        
    }
    
    public function testCSV(): void
    {
        $GLOBALS['newline'] = "\n";

        $data = [
            'date' => '2014-12-31',
            'id' => 4,
            'client_type' => 'private',
            'operation_type' => 'withdraw',
            'amount' => 1200.00,
            'currency_iso3' => 'EUR',
            'line' => 1
        ];

        $operation = new Operation($data);
        $result = $operation->calculateComission();
        $this->expectOutputString("0.60\n", $result);
    }
}