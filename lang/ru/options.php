<?php
$MESS['PAGE_TITLE'] = 'Настройки';

$MESS['TAB_MAIN_TITLE'] = 'Настройки';
$MESS['TAB_SECURITY_TITLE'] = 'Безопасность';
$MESS['TAB_SUPPORT_TITLE'] = 'Поддержка';

$MESS['TAB_MAIN_DESCRIPTION'] = 'Основные настройки';
$MESS['TAB_SECURITY_DESCRIPTION'] = 'Настройки безопасности';
$MESS['TAB_SUPPORT_DESCRIPTION'] = 'Поддержка модуля';

$MESS['OPTION_USE_RESTFUL_API'] = 'Использовать RESTful API';
$MESS['OPTION_USE_RESTFUL_API_SELECT_TITLE_1'] = 'Отключено';
$MESS['OPTION_USE_RESTFUL_API_SELECT_TITLE_2'] = 'Включено';
$MESS['OPTION_USE_RESTFUL_API_SELECT_ID_1'] = 'N';
$MESS['OPTION_USE_RESTFUL_API_SELECT_ID_2'] = 'Y';
$MESS['OPTION_USE_RESTFUL_API_SELECT_HINT'] = 'Если параметр включён, тогда будет возможность использовать RESTful API на сайте.';

$MESS['OPTION_PATH_RESTFUL_API'] = 'Путь RESTful API';
$MESS['OPTION_PATH_RESTFUL_HINT'] = 'Путь по которому будет доступен интерфейс.<br><br>Пример: <b>/api/</b>';

$MESS['OPTION_USE_VERSIONS'] = 'Использовать версии';
$MESS['OPTION_USE_VERSIONS_SELECT_TITLE_1'] = 'Отключено';
$MESS['OPTION_USE_VERSIONS_SELECT_TITLE_2'] = 'Включено';
$MESS['OPTION_USE_VERSIONS_SELECT_ID_1'] = 'N';
$MESS['OPTION_USE_VERSIONS_SELECT_ID_2'] = 'Y';
$MESS['OPTION_USE_VERSIONS_SELECT_HINT'] = 'Если параметр включён, тогда будет учитываться версия контроллера обрабатывающего запрос.<br><br>Например: /api/<b>v1</b>/ - в этом случае интерфейс будет подключать контроллер, который располагается по пути: [папка модуля]/lib/controllers/<b>v1</b>/[название контроллера].';


$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER'] = 'Использовать фильтр по белым IP-адресам';
$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_TITLE_1'] = 'Отключен';
$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_TITLE_2'] = 'Включен';
$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_ID_1'] = 'N';
$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_ID_2'] = 'Y';
$MESS['OPTION_USE_WHITE_LIST_ADDRESS_FILTER_HINT'] = 'Если параметр включён, тогда при обработке входящего запроса будет проверяться источник запроса.';
$MESS['OPTION_WHITE_LIST_ADDRESS_TITLE'] = 'Список белых адресов';
$MESS['OPTION_WHITE_LIST_ADDRESS_HINT'] = 'Список разрешенных адресов, с которых API-интерфейс будет обрабатывать входящие запросы.<br>Адреса нужно писать через точку с запятой.<br><br>Пример: 192.168.0.1; 192.168.0.2; 192.168.0.3';

$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER'] = 'Использовать фильтр по чёрным IP-адресам';
$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_TITLE_1'] = 'Отключен';
$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_TITLE_2'] = 'Включен';
$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_ID_1'] = 'N';
$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_ID_2'] = 'Y';
$MESS['OPTION_USE_BLACK_LIST_ADDRESS_FILTER_HINT'] = 'Если параметр включён, тогда при обработке входящего запроса будет проверяться источник запроса.';
$MESS['OPTION_BLACK_LIST_ADDRESS_TITLE'] = 'Список чёрных адресов';
$MESS['OPTION_BLACK_LIST_ADDRESS_HINT'] = 'Список запрещенных адресов, с которых API-интерфейс НЕ будет обрабатывать входящие запросы.<br>Адреса нужно писать через точку с запятой.<br><br>Пример: 192.168.0.1; 192.168.0.2; 192.168.0.3';


$MESS['OPTION_USE_LIST_COUNTRY_FILTER'] = 'Использовать фильтр по коду страны';
$MESS['OPTION_USE_LIST_COUNTRY_FILTER_SELECT_TITLE_1'] = 'Отключен';
$MESS['OPTION_USE_LIST_COUNTRY_FILTER_SELECT_TITLE_2'] = 'Включен';
$MESS['OPTION_USE_LIST_COUNTRY_FILTER_SELECT_ID_1'] = 'N';
$MESS['OPTION_USE_LIST_COUNTRY_FILTER_SELECT_ID_2'] = 'Y';
$MESS['OPTION_USE_LIST_COUNTRY_FILTER_HINT'] = 'Если параметр включён, тогда при обработке входящего запроса будет проверяться код страны источника запроса.';
$MESS['OPTION_WHITE_LIST_COUNTRY_TITLE'] = 'Список кодов стран';
$MESS['OPTION_WHITE_LIST_COUNTRY_HINT'] = 'Список разрешенных кодов стран, с которых API-интерфейс будет обрабатывать входящие запросы.<br>Коды нужно писать через точку с запятой.<br><br>Пример: RU, KZ, BY';


$MESS['SUPPORT_LINK_TITLE'] = 'Вопросы и предложения по модулю';
$MESS['SUPPORT_LINK'] = 'http://artamonov.pro';
$MESS['SUPPORT_LINK_TEXT'] = 'Перейти на сайт';

$MESS['SUPPORT_DOCUMENTATION_LINK_TITLE'] = 'Документация';
$MESS['SUPPORT_DOCUMENTATION_LINK'] = 'https://gitlab.com/artamonov.denis/artamonov.api/wikis/home';
$MESS['SUPPORT_DOCUMENTATION_LINK_TEXT'] = 'Перейти на сайт';

$MESS['OPTION_SUPPORT_USE_LOG_TITLE'] = 'Логирование входящих запросов';
$MESS['OPTION_SUPPORT_USE_LOG_SELECT_TITLE_1'] = 'Отключено';
$MESS['OPTION_SUPPORT_USE_LOG_SELECT_TITLE_2'] = 'Включено';
$MESS['OPTION_SUPPORT_USE_LOG_SELECT_ID_1'] = 'N';
$MESS['OPTION_SUPPORT_USE_LOG_SELECT_ID_2'] = 'Y';
$MESS['OPTION_SUPPORT_USE_LOG_HINT'] = 'Логирование всех входящих запросов в файл';

$MESS['OPTION_SUPPORT_LOG_PATH_TITLE'] = 'Путь до лог-файла';
$MESS['OPTION_SUPPORT_LOG_PATH_HINT'] = 'Путь по которому будет доступен лог-файл.<br><br>Пример: <b>/logs/api.log</b><br><br>Примечание: файл и директория должны быть созданы заранее, а также должны быть настроены права на запись в файл.';



$MESS['BTN_OPTIONS_SAVE'] = 'Сохранить';
$MESS['BTN_OPTIONS_RESTORE'] = 'Сбросить';
$MESS['OPTIONS_SAVED'] = 'Настройки сохранены';
$MESS['OPTIONS_RESTORED'] = 'Настройки сброшены';