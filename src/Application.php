<?php



class Application
{
    public function run()
    {
        include_once __DIR__ . '/Router.php';
        $router = new Router();
        $router->handle();


    }

}