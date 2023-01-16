<?php

namespace Source\Core\Components;
use Source\Core\Helpers\CsvParser;

//main controller of operations. It is kind off redundant, but it allows flexible development in the future (adding new features, etc.)
class ComissionController
{

    /**
     * @var CsvParser $csvParser CSV Parser Helper class
     */
    protected $csvParser;

    function __construct($file_name)
    {
        $this->csvParser = new CsvParser($file_name);
    }

    /**
     * @throws \Exception
     */
    public function manageTransactions(): void
    {
        echo("Managing operations... " . $GLOBALS['newline']);
        $this->csvParser->parseCsv();
    }
}
