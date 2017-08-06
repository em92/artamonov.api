<?php


namespace Artamonov\Api;


class Init
{
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
        return (!$this->checkFilterCountry() || !$this->checkFilterAddress()) ? false : true;
    }
    private function checkFilterCountry()
    {
        $result = true;

        if ($this->getParameter()->getValue('USE_LIST_COUNTRY_FILTER') == 'Y') {

            $ar = $this->getParameter()->getValue('WHITE_LIST_COUNTRY');
            $ar = explode(';', $ar);
            $ar = array_diff($ar, ['']);

            foreach ($ar as &$item) {
                $item = trim($item);
                $item = strtoupper($item);
            }

            if (!in_array($this->getCountryCode(), $ar)) {
                $result = false;
            }
        }

        return $result;
    }
    private function checkFilterAddress()
    {
        $result = true;

        if ($this->getParameter()->getValue('USE_BLACK_LIST_ADDRESS_FILTER') == 'Y') {

            // Black list
            $arBlack = $this->getParameter()->getValue('BLACK_LIST_ADDRESS');
            $arBlack = explode(';', $arBlack);
            $arBlack = array_diff($arBlack, ['']);

            foreach ($arBlack as &$item) {
                $item = trim($item);
            }

            if (in_array($this->getRealIpAddr(), $arBlack)) {

                $result = false;
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

            $result = (in_array($this->getRealIpAddr(), $arWhite)) ? true : false;
        }

        return $result;
    }

    public function getCountryCode()
    {
        return ($countryCode = geoip_country_code_by_name(self::$realIp)) ? strtoupper($countryCode) : 'RU';
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

}