<?php


namespace Artamonov\Api;


class Router extends Init
{
    private static $apiVersion;
    private static $controller;
    private static $action;
    private static $params;


    // MAIN METHODS


    public function start()
    {
        $path_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        // Delete module name
        array_shift($path_parts);

        // Get version
        if ($this->checkUseVersion()) {

            if (current($path_parts)) {
                self::$apiVersion = strtolower(current($path_parts));
                array_shift($path_parts);
            }
        }

        // Get controller
        if (current($path_parts)) {

            self::$controller = strtolower(current($path_parts));
            array_shift($path_parts);
        }

        // Get action
        if (current($path_parts)) {

            self::$action = strtolower(current($path_parts));
            array_shift($path_parts);
        }

        // Get params
        switch (parent::getMethod()) {

            case 'POST':
                $path_parts = $_POST;
                break;

            case 'GET':

                if (count($path_parts) > 0) {

                    // if original get-request
                    if (strstr($_SERVER['REQUEST_URI'], '?', false) !== false) {

                        $path_parts = $_SERVER['QUERY_STRING'];
                        $path_parts = explode('&', $path_parts);

                        $tmp = [];

                        foreach ($path_parts as $item) {

                            $item = explode('=', $item);
                            $tmp[urldecode($item[0])] = urldecode($item[1]);
                        }

                        $path_parts = $tmp;
                    }
                }

                break;

            case 'PUT':
                $_PUT = [];

                $putdata = file_get_contents('php://input');
                $putdata = explode('&', $putdata);

                foreach($putdata as $pair) {
                    $item = explode('=', $pair);
                    if(count($item) == 2) {
                        $_PUT[urldecode($item[0])] = urldecode($item[1]);
                    }
                }

                $path_parts = $_PUT;
                break;

            case 'DELETE':
                $_DELETE = [];

                $deleteData = file_get_contents('php://input');
                $deleteData = explode('&', $deleteData);

                foreach($deleteData as $pair) {
                    $item = explode('=', $pair);
                    if(count($item) == 2) {
                        $_DELETE[urldecode($item[0])] = urldecode($item[1]);
                    }
                }

                $path_parts = $_DELETE;
                break;
        }

        self::$params = $path_parts;

        // Run controller
        if ($this->getController() && $this->getAction()) {

            $controller = new Controller();
            $controller->run();

        } else {

            Response::BadRequest();
        }

        die();
    }


    // ADDITIONAL METHODS


    // PARAMETERS

    private function checkUseVersion()
    {
        return (parent::getParameter()->getValue('USE_VERSIONS') == 'Y') ? true : false;
    }

    public function getApiVersion()
    {
        return self::$apiVersion;
    }
    public function getController()
    {
        return self::$controller;
    }
    public function getAction()
    {
        return self::$action;
    }
    public function getParameters()
    {
        return self::$params;
    }
}