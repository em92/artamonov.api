<?php


namespace Artamonov\Api;


class Router extends Init
{
    private static $apiPath;
    private static $apiVersion;
    private static $controller;
    private static $action;
    private static $params;

    public function start()
    {
        $pathParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        // Api path
        self::$apiPath = strtolower(current($pathParts));
        array_shift($pathParts);
        // Get version
        if ($this->checkUseVersion()) {
            if (current($pathParts)) {
                self::$apiVersion = strtolower(current($pathParts));
                array_shift($pathParts);
            }
        }
        // Get controller
        if (current($pathParts)) {
            self::$controller = strtolower(current($pathParts));
            array_shift($pathParts);
        }
        // Get action
        if (current($pathParts)) {
            self::$action = strtolower(current($pathParts));
            array_shift($pathParts);
        }
        // Get params
        switch (parent::getMethod()) {
            case 'GET':
                $requestUri = str_replace('/?', '?', $_SERVER['REQUEST_URI']);
                if (strstr($requestUri, '?', false) !== false) {
                    if (strstr(self::$action, '?', false) !== false) {
                        self::$action = explode('?', self::$action)[0];
                    }
                    $pathParts = explode('?', $requestUri);
                    $pathParts = ($pathParts[1]) ? explode('&', $pathParts[1]) : [];
                    if ($pathParts) {
                        $tmp = [];
                        foreach ($pathParts as $item) {
                            $item = explode('=', $item);
                            $tmp[urldecode($item[0])] = urldecode($item[1]);
                        }
                        $pathParts = $tmp;
                    }
                }
                break;
            case 'POST':
                $pathParts = ($_SERVER['CONTENT_TYPE'] == 'application/json') ? json_decode(file_get_contents('php://input'), true) : $_POST;
                break;
            case 'PUT':
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $pathParts = json_decode(file_get_contents('php://input'), true);
                }
                break;
            case 'DELETE':
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $pathParts = json_decode(file_get_contents('php://input'), true);
                }
                break;
            case 'OPTIONS':
                if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                    $pathParts = json_decode(file_get_contents('php://input'), true);
                }
                break;
        }
        self::$params = (count($pathParts) > 0) ? $pathParts : [];
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

    public function getApiPath()
    {
        return self::$apiPath;
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