<?php


class User
{
    /** @var CLIDescription */
    private $descriptions;

    /** @var Validator */
    private $validator;

    public function __construct()
    {
        include_once __DIR__ . '/Descriptions/CLIDescription.php';
        $this->descriptions = new CLIDescription();
        include_once __DIR__ . '/Validator.php';
        $this->validator = new Validator();
    }


    public function create()
    {
        $this->descriptions->printDescription('name');
        $handle = fopen("php://stdin", "r");
        $name = trim(fgets($handle));
        $this->descriptions->printDescription('email');
        $email = trim(fgets($handle));
        $this->descriptions->printDescription('phone_number');
        $phoneNumber = trim(fgets($handle));
        $this->descriptions->printDescription('identification_number');
        $identificationNumber = trim(fgets($handle));
        $this->descriptions->printDescription('date');
        $date = trim(fgets($handle));
        $date = date('Y-m-d', strtotime($date));
        $this->descriptions->printDescription('time');
        $time = trim(fgets($handle));
        $time = date('H:i', strtotime($time));

        $userData = [
            'id' => 'U' . rand(1111, 9999),
            'name' => $name,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'identification_number' => $identificationNumber,
            'date' => $date,
            'time' => $time,
        ];

        $validationErrors = $this->validator->validate($userData);
        $killExecution = false;
        foreach ($validationErrors as $error){
            if(is_string($error)){
                $killExecution = true;
                echo $error . PHP_EOL;
            }

        }
        if($killExecution === true){
            return $this->create();
        }

        $file = fopen('data.csv', 'a');
        fputcsv($file, $userData);
        fclose($file);

        $readFile = fopen('data.csv', 'r');
        while (($line = fgetcsv($readFile, 1000, ',')) !== false) {
            $num = count($line);
//            var_dump($line, $num);
        }

    }

    public function edit()
    {
        $format = $this->format();


        $this->descriptions->printDescription('edit_registration');

        $data = fopen('data.csv', 'r');
        $temp_table = fopen('temp_table.csv', 'w');
        $handle = fopen("php://stdin", "r");
        $userId = trim(fgets($handle));

        while (($fileLine = fgetcsv($data, 1000)) !== false) {
            if ($fileLine[0] == $userId) {
                printf($format, 'ID', 'name', 'email', 'phone_number', 'identification_number', 'date', 'time');
                printf($format, $fileLine[0], $fileLine[1], $fileLine[2], $fileLine[3], $fileLine[4], $fileLine[5], $fileLine[6]);

                $this->writeName($fileLine);

                $this->writeEmail($fileLine);

                $this->writePhone($fileLine);

                $this->writePersonalCode($fileLine);

                $fileLine[5] = $this->writeDate($fileLine);

                $fileLine[6] = $this->writeTime($fileLine);


            }
            fputcsv($temp_table, $fileLine);
        }

        fclose($temp_table);
        fclose($data);
        rename('temp_table.csv', 'data.csv');
    }



    public function delete()
    {
        $format = $this->format();

        $this->descriptions->printDescription('delete_registration');

        $data = fopen('data.csv', 'r');
        $temp_table = fopen('temp_table.csv', 'w');

        $handle = fopen("php://stdin", "r");
        $userId = trim(fgets($handle));


        while (($fileLine = fgetcsv($data, 1000)) !== false) {
            if ($fileLine[0] == $userId) {
                echo 'Registration deleted';
                continue;
            }
            fputcsv($temp_table, $fileLine);
        }

        fclose($data);
        fclose($temp_table);
        rename('temp_table.csv', 'data.csv');

    }

    public function print()
    {
        $readFile = fopen('data.csv', 'r');
        while (($line = fgetcsv($readFile, 1000, ',')) !== false) {

            echo 'ID: ' . $line[0] . PHP_EOL;
        }

    }

    private function format()
    {
        $format = "|%10s|%-10.10s|%25s|%10s|%25s|%10s|%10s \n";
        printf($format, 'ID', 'name', 'email', 'phone_number', 'identification_number', 'date', 'time');
        $readFile = fopen('data.csv', 'r');
        while (($line = fgetcsv($readFile, 1000, ',')) !== false) {
            printf($format, $line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
        }
        fclose($readFile);

        return $format;
    }

    private function writeName(&$fileLine, &$isValid = false)
    {
        if ($isValid) {
            return;
        }
        $this->descriptions->printDescription('edit_name');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            if (!$this->validator->validateName($answ)) {
                $this->descriptions->printDescription('not_valid');
                $this->writeName($fileLine, $isValid);
            }
            $fileLine[1] = $answ;
            $isValid = true;
        }
    }

    private function writeEmail(&$fileLine, &$isValid = false)
    {
        if ($isValid) {
            return;
        }
        $this->descriptions->printDescription('edit_email');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            if (!$this->validator->validateEmail($answ)) {
                $this->descriptions->printDescription('not_valid');
                $this->writeEmail($fileLine, $isValid);
            }
            $fileLine[2] = $answ;
            $isValid = true;
        }
    }

    private function writePhone(&$fileLine, &$isValid = false)
    {
        if ($isValid) {
            return;
        }
        $this->descriptions->printDescription('edit_phone');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            if (!$this->validator->validatePhoneNumber($answ)) {
                $this->descriptions->printDescription('not_valid');
                $this->writePhone($fileLine, $isValid);
            }


        }
        $fileLine[3];
        $isValid = true;
    }

    private function writePersonalCode(&$fileLine, &$isValid = false)
    {
        if ($isValid) {
            return;
        }
        $this->descriptions->printDescription('edit_personal_code');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            if ($this->validator->validatePersonalCode($answ)) {
                $this->descriptions->printDescription('not_valid');
                $this->writePersonalCode($fileLine, $isValid);
            }

        }
        $fileLine[4] ;
        $isValid = true;
    }

    private function writeDate($fileLine)
    {
        $this->descriptions->printDescription('edit_date');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            $date = date('Y-m-d', strtotime($answ));
            return $date;
        }

        return $fileLine[5];
    }

    private function writeTime($fileLine)
    {
        $this->descriptions->printDescription('edit_time');
        $handle = fopen("php://stdin", "r");
        $answ = trim(fgets($handle));
        if ($answ !== '') {
            $time = date('H:i', strtotime($answ));
            return $time;

        }
        return $fileLine[6];
    }

}