<?php


namespace Artamonov\Api;


class Init
{
    const GEOIP = 'Geoip';

    private $parameter;
    private $pathApi;
    public static $realIp;


    public function __construct()
    {
        $this->parameter = new Options();
    }


    // MAIN METHODS


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

                // Close access
                Response::DenyAccess();
            }

            die();
        }
    }


    // ADDITIONAL METHODS


    // PARAMETERS

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

    // API PATH

    private function getPathApi()
    {
        if (!$this->pathApi) {
            $this->pathApi = $this->getParameter()->getValue('PATH_RESTFUL_API');
        }

        return $this->pathApi;
    }
    private function checkPathApi()
    {
        $result = false;

        $current_module = explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $api_module = explode('/', trim($this->getPathApi(), '/'))[0];

        if ($current_module == $api_module) {
            $result = true;
        }

        return $result;
    }

    // FILTERS

    private function checkFilters()
    {
        $result = (!$this->checkFilterCountry() || !$this->checkFilterAddress() || !$this->checkAccessHttps()) ? false : true;

        return $result;
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
        $access = true;

        if ($this->getParameter()->getValue('ONLY_HTTPS_EXCHANGE') == 'Y' && $_SERVER['SERVER_PORT'] != 443) {
            $access = false;
        }

        return $access;
    }

    public function getCountryCode()
    {
        // Default country
        $defaultCountryCode = 'RU';

        // Check library availability geoip
        if (self::checkLibraryAvailability(self::GEOIP)) {

            $result = ($countryCode = strtoupper(geoip_country_code_by_name(self::$realIp))) ? $countryCode : $defaultCountryCode;

        } else {

            $result = 'Error: the '.self::GEOIP.' library was not found';
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
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        // Cross domain
        header('Access-Control-Allow-Origin: '.$_SERVER['SERVER_NAME']);

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

                        header('Access-Control-Allow-Origin: '.$item);
                        break;
                    }
                }
            }
        }
    }

    // EXTENSIONS
    public static function checkLibraryAvailability($libraryCode)
    {
        $result = false;

        // Installed extensions
        $extensions = get_loaded_extensions();

        if ($exist = array_search(strtolower($libraryCode), $extensions)) {
            $result = true;
        }

        return $result;
    }
}