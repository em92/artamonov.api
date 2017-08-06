<?php


namespace Artamonov\Api\Controllers\v1;


use Artamonov\Api\Request;
use Artamonov\Api\Response;

class User
{
    // MAIN METHOD

    public function get()
    {
        $arResult = $this->getRequest();

        Response::ShowResult($arResult);
    }


    // ADDITIONAL METHOD

    private function getRequest()
    {
        return Request::get();
    }
}