<?php

namespace Source\Core\Helpers;

use Source\Entities\Operation;
use Source\Core\Constants\Operation as OperationConstants;

//CSV Parser class to check, validate and read from a CSV file.
//It creates Operations objects for each read line of the csv
class CsvParser
{
    /**
     * @var string $file_name
     */
    protected $file_name;

    function __construct(string $file_name)
    {
        $this->file_name = $file_name;
        $this->validateFile();
    }

    /**
     * @param array $dates_passed
     * @param string $current_date
     * 
     * @throws \Exception
     */
    private function validateFile(): void
    {
        if (!file_exists($this->file_name)) {
            throw new \Exception("The file $this->file_name does not exist!" . $GLOBALS['newline']);
        }

        if (empty(pathinfo($this->file_name)['extension']) || pathinfo($this->file_name)['extension'] != "csv") {
            throw new \Exception("The file $this->file_name has wrong extension! Only .csv is supported!" . $GLOBALS['newline']);
        }
    }

    /**
     * @param array $data
     * @param int $line
     * 
     * @throws \Exception
     */
    private function validateData(&$data, $line): void
    {
        $num = count($data);
        if ($num != 6) {
            throw new \Exception("The file $this->file_name has wrong format on line $line!" . $GLOBALS['newline']);
        }

        $data[6] = $line;
    }

    /**
     * @param array $data
     */
    private function parseData(&$data): void
    {
        foreach ($data as $key => $datum) {
            unset($data[$key]);
            $new_key = OperationConstants::CSV_MAPPING[$key];
            $data[$new_key] = $datum;
        }
    }

    /**
     * @throws \Exception
     */
    public function parseCsv(): void
    {
        $line = 1;

        //read each line of the CSV, validate the num of rows at first and create new Operation,
        //which will create Private or Business clients and calls their operation
        if (($handle = fopen($this->file_name, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $this->validateData($data, $line);
                $this->parseData($data);
                $operation = new Operation($data);
                $operation->calculateComission();

                $line++;
            }
            fclose($handle);
        }
    }
}