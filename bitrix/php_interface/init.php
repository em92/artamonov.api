<?php
use Bitrix\Main\Loader;
use Artamonov\Api\Init as Api;

if (Loader::includeModule('artamonov.api')) {
    $api = new Api();
    $api->start();
}