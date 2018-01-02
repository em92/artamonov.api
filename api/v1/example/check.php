<?php

use Artamonov\Api\Request;
use Artamonov\Api\Response;
use Bitrix\Main\Loader;
use CIBlockElement;

$arResult['CURRENT_REQUEST'] = Request::get();
$arResult['OPERATING_METHOD'] = 'FILE';

if (Loader::includeModule('iblock')) {

    if ($result = CIBlockElement::getList(['ID' => 'DESC'], ['IBLOCK_ID' => 1, 'ACTIVE' => 'Y'], false, false, ['ID', 'NAME'])) {

        while ($ar = $result->fetch()) {

            $arResult['IBLOCK'][] = $ar;
        }
    }
}

Response::ShowResult($arResult);