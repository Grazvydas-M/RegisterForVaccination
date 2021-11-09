<?php

class Validator
{

    public function validateName(string $name)
    {
        if (ctype_alpha($name)) {

            return true;
        }

        return false;
    }

    public function validateEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            return true;
        }

        return false;
    }

    public function validatePhoneNumber($phone)
    {
        if (preg_match('/(86|\+3706)\d{3}\d{4}/', $phone)) {

            return true;
        }

        return false;
    }

    //nepabaigta validacija
    public function validatePersonalCode(string $personalCode)
    {
        if (!is_numeric($personalCode) || strlen($personalCode) != 11) {
            return true;
        }

        return false;
    }

    public function validate(array $data)
    {
        $validationErrors = [];

        if (isset($data['email'])) {
            $validationErrors['email'] = $this->validateEmail($data['email']) ? NULL: 'Email not valid';
        }
        if (isset($data['phone_number'])){
            $validationErrors['phone_number'] = $this->validatePhoneNumber($data['phone_number']) ? NULL: 'Phone number is not valid';
        }
//        if(isset($data['identification_number']))
//            $validationErrors= $this->validatePersonalCode($data['identification_number']) ? NULL: 'Identification number is not valid';
        return $validationErrors;

    }


}





