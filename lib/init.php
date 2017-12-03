<?php


namespace Artamonov\Api;


use Bitrix\Main\Application;

class Init
{
    const GEOIP = 'Geoip';

    private $parameter;
    public static $realIp;

    public function __construct()
    {
        $this->parameter = new Options();
    }

    public function start()
    {
        // If the module is activated
        if ($this->checkPathApi() && $this->checkUseApi()) {
            // Check filters
            if ($this->checkFilters()) {
                // Set headers
                $this->setHeaders();
                // Run router/dispatch
                $router = new Router();
                $router->start();
            } else {
                // Cross domain
                if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS' && $_SERVER['HTTP_ORIGIN']) {
                    $this->setHeadersPreQuery();
                } else {
                    // Close access
                    Response::DenyAccess();
                }
            }
            die();
        }
    }

    public function getParameter()
    {
        return $this->parameter;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function checkUseApi()
    {
        return ($this->getParameter()->getValue('USE_RESTFUL_API') == 'Y') ? true : false;
    }

    private function checkPathApi()
    {
        $apiPath = trim($this->getParameter()->getValue('PATH_RESTFUL_API'), '/');
        $currentModule = explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $apiModule = explode('/', $apiPath)[0];
        return ($currentModule == $apiModule) ? true : false;
    }

    // FILTERS

    private function checkFilters()
    {
        return (!$this->checkToken() || !$this->checkFilterCountry() || !$this->checkFilterAddress() || !$this->checkAccessHttps()) ? false : true;
    }

    private function checkFilterCountry()
    {
        $access = true;
        if ($this->getParameter()->getValue('USE_LIST_COUNTRY_FILTER') == 'Y') {
            $ar = $this->getParameter()->getValue('WHITE_LIST_COUNTRY');
            $ar = explode(';', $ar);
            $ar = array_diff($ar, ['']);
            foreach ($ar as &$item) {
                $item = trim($item);
                $item = strtoupper($item);
            }
            if (!in_array($this->getCountryCode(), $ar)) {
                $access = false;
            }
        }
        return $access;
    }

    private function checkFilterAddress()
    {
        $access = true;
        if ($this->getParameter()->getValue('USE_BLACK_LIST_ADDRESS_FILTER') == 'Y') {
            // Black list
            $arBlack = $this->getParameter()->getValue('BLACK_LIST_ADDRESS');
            $arBlack = explode(';', $arBlack);
            $arBlack = array_diff($arBlack, ['']);
            foreach ($arBlack as &$item) {
                $item = trim($item);
            }
            if (in_array($this->getRealIpAddr(), $arBlack)) {
                $access = false;
            }
        }
        if ($this->getParameter()->getValue('USE_WHITE_LIST_ADDRESS_FILTER') == 'Y') {
            // White list
            $arWhite = $this->getParameter()->getValue('WHITE_LIST_ADDRESS');
            $arWhite = explode(';', $arWhite);
            $arWhite = array_diff($arWhite, ['']);
            foreach ($arWhite as &$item) {
                $item = trim($item);
            }
            $access = (in_array($this->getRealIpAddr(), $arWhite)) ? true : false;
        }
        return $access;
    }

    private function checkAccessHttps()
    {
        return ($this->getParameter()->getValue('ONLY_HTTPS_EXCHANGE') == 'Y' && $_SERVER['SERVER_PORT'] != 443) ? false : true;
    }

    private function checkToken()
    {
        $access = true;
        if ($this->getParameter()->getValue('USE_AUTH_TOKEN') == 'Y') {
            $access = false;
            if ($_SERVER['HTTP_AUTHORIZATION_TOKEN']) {
                $token = $_SERVER['HTTP_AUTHORIZATION_TOKEN'];
                $keyword = str_replace(' ', '', $this->getParameter()->getValue('TOKEN_KEYWORD')) . ':';
                $checkKeyword = substr($token, 0, strlen($keyword));
                if ($checkKeyword != $keyword) {
                    return false;
                }
                $token = trim(substr($token, strlen($keyword)));
                if ($userId = $this->DB()->query('SELECT VALUE_ID FROM b_uts_user WHERE ' . $this->getParameter()->getUserFieldCodeApiToken() . '="' . $token . '" LIMIT 1')->fetch()['VALUE_ID']) {
                    $access = true;
                }
            }
        }
        return $access;
    }

    public function getCountryCode()
    {
        $defaultCountryCode = 'RU';
        if (self::checkLibraryAvailability(self::GEOIP)) {
            $result = ($countryCode = strtoupper(geoip_country_code_by_name(self::$realIp))) ? $countryCode : $defaultCountryCode;
        } else {
            $result = 'Error: the ' . self::GEOIP . ' library was not found';
        }
        return $result;
    }

    public function getRealIpAddr()
    {
        if (!self::$realIp) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                self::$realIp = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                self::$realIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                self::$realIp = $_SERVER['REMOTE_ADDR'];
            }
        }
        return self::$realIp;
    }

    // HEADERS

    private function setHeaders()
    {
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization-Token');
        // Cross domain
        header('Access-Control-Allow-Origin: ' . $_SERVER['SERVER_NAME']);
        if ($this->getParameter()->getValue('USE_ACCESS_CONTROL_ALLOW_ORIGIN_FILTER') == 'Y') {
            $ar = $this->getParameter()->getValue('WHITE_LIST_DOMAIN_ACCESS_CONTROL_ALLOW_ORIGIN');
            if (strpos($ar, '*') !== false) {
                header('Access-Control-Allow-Origin: *');
            } else {
                $ar = explode(';', $ar);
                $ar = array_diff($ar, ['']);
                foreach ($ar as &$item) {
                    $item = trim($item);
                    if ($item == $_SERVER['HTTP_ORIGIN']) {
                        header('Access-Control-Allow-Origin: ' . $item);
                        break;
                    }
                }
            }
        }
    }

    private function setHeadersPreQuery()
    {
        header('HTTP/1.0 200');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization-Token');
        header('Access-Control-Max-Age: 604800'); // 7 days
        if ($this->getParameter()->getValue('USE_ACCESS_CONTROL_ALLOW_ORIGIN_FILTER') == 'Y') {
            $ar = $this->getParameter()->getValue('WHITE_LIST_DOMAIN_ACCESS_CONTROL_ALLOW_ORIGIN');
            if (strpos($ar, '*') !== false) {
                header('Access-Control-Allow-Origin: *');
            } else {
                $ar = explode(';', $ar);
                $ar = array_diff($ar, ['']);
                foreach ($ar as &$item) {
                    $item = trim($item);
                    if ($item == $_SERVER['HTTP_ORIGIN']) {
                        header('Access-Control-Allow-Origin: ' . $item);
                        break;
                    }
                }
            }
        }
    }

    public static function checkLibraryAvailability($libraryCode)
    {
        return array_search(strtolower($libraryCode), get_loaded_extensions()) ? true : false;
    }

    private function DB()
    {
        return Application::getConnection();
    }
}