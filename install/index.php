<?php

use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

class artamonov_api extends CModule
{
    var $MODULE_ID = 'artamonov.api';
    
    public function __construct()
    {
        $this->MODULE_ID = 'artamonov.api';
        $this->MODULE_NAME = 'RESTful API';
        $this->MODULE_DESCRIPTION = 'Модуль помогает организовать API-интерфейс';
        $this->MODULE_VERSION = '3.1.0';
        $this->MODULE_VERSION_DATE = '2017-09-09 21:00:00';
        $this->PARTNER_NAME = 'Артамонов Денис';
        $this->PARTNER_URI = 'http://artamonov.pro/';
    }

    function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
        $GLOBALS['APPLICATION']->IncludeAdminFile(Loc::getMessage('API_INSTALL_TITLE'), __DIR__ . '/step.php');
    }

    function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
        $GLOBALS['APPLICATION']->IncludeAdminFile(Loc::getMessage('API_UNINSTALL_TITLE'), __DIR__ . '/unstep.php');
    }
}