<?php


class CLIDescription
{
    public function getDescription(string $key)
    {
        $description = [
            'add'=> "If you want to add an appointment write - \033[36madd\033[0m",
            'edit'=> "To edit an appointment write - \033[36medit\033[0m",
            'print'=>"Print specific date appointments write - \033[36mprint\033[0m",
            'delete'=>"To delete appointment write - \033[36mdelete\033[0m",
            'name'=>'Write user name',
            'email'=>'Write user email',
            'phone_number'=> 'Write phone number',
            'identification_number'=>'Write persons ID number',
            'date'=>'Write registration date yyyy-mm-dd',
            'time'=>'Write registration time HH:MM"',
            'delete_registration' => 'Enter user ID to delete user',
            'edit_registration' => 'Enter user ID to edit registration details',
            'edit_name' => 'Enter new name or press Enter to continue',
            'edit_email' => 'Enter new email or press Enter to continue',
            'edit_phone' => 'Enter new phone number or press Enter to continue',
            'edit_personal_code' => 'Enter new personal code or press Enter to continue',
            'edit_date' => 'Enter new date (yyyy-mm-dd) or press Enter to continue',
            'edit_time' => 'Enter new time or press Enter to continue',
            'new_name' => 'Write a new name',
            'new_email' => 'Write an email address',
            'not_valid' => 'Value is not valid',

        ] ;

        return $description[$key];
    }

    public function printDescription(string $key)
    {
        echo $this->getDescription($key) . PHP_EOL;
    }

}