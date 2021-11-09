<?php


class Router
{
    public function __construct()
    {

    }

    public function printRoutesDescriptions()
    {

    }

    public function handle()
    {
        $this->printDescriptions();
        $this->load();

    }

    public function load()
    {
        $handle = fopen("php://stdin", "r");
        $payload = trim(fgets($handle));

        include_once __DIR__ . '/User.php';
        $user = new User();

        switch ($payload) {
            case 'add':
                $user->create();
                break;
            case 'edit':
                $user->edit();
                break;
            case 'print':
                $user->print();
                break;
            case 'delete';
                $user->delete();
                break;
            default:
                die('This action is not allowed');
        }

    }

    public function printDescriptions()
    {
        include_once __DIR__ . '/Descriptions/CLIDescription.php';
        $desc = new CLIDescription();
        echo $desc->getDescription('add') . PHP_EOL;
        echo $desc->getDescription('edit') . PHP_EOL;
        echo $desc->getDescription('print') . PHP_EOL;
        echo $desc->getDescription('delete') . PHP_EOL;
    }

}