<?php

use Bitrix\Main\Localization\Loc;

return [
    [
        'parent_menu' => 'global_menu_services',
        'section' => 'restful-api',
        'sort' => 1,
        'module_id' => Loc::getMessage('API_MODULE_ID'),
        'items_id' => 'menu_'.Loc::getMessage('API_MODULE_ID'),
        'icon' => 'clouds_menu_icon',
        'page_icon' => 'clouds_menu_icon',
        'text' => Loc::getMessage('API_MODULE_NAME'),
        'items' => [

            [
                'items_id' => 'menu_'.Loc::getMessage('API_MODULE_ID').'_setting',
                'sort' => 1,
                'icon' => 'sys_menu_icon',
                'page_icon' => 'sys_menu_icon',
                'text' => Loc::getMessage('SETTING'),
                'url' => 'settings.php?lang='.LANG.'&mid='.Loc::getMessage('API_MODULE_ID').'&mid_menu=1'
            ]
        ]
    ]
];