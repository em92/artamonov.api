<?php


namespace Artamonov\Api;


use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

class Controller extends Router
{
    const ROOT_DIR_CONTROLLERS = 'controllers';


    // MAIN METHODS


    public function run()
    {
        if (parent::getApiVersion()) {

            $path = __DIR__ . DIRECTORY_SEPARATOR . self::ROOT_DIR_CONTROLLERS . DIRECTORY_SEPARATOR . parent::getApiVersion() . DIRECTORY_SEPARATOR . strtolower(parent::getController()) . '.php';

            if (file_exists($path)) {
                $controller = __NAMESPACE__ . '\\' . self::ROOT_DIR_CONTROLLERS . '\\' . parent::getApiVersion() . '\\' . ucfirst(strtolower(parent::getController()));
            } else {
                Response::BadRequest(Loc::getMessage('CLASS_NOT_FOUND', ['#OBJECT#' => ucfirst(parent::getController())]) . ' [' . parent::getApiVersion() . ']');
            }

        } else {

            $path = __DIR__ . DIRECTORY_SEPARATOR . self::ROOT_DIR_CONTROLLERS . DIRECTORY_SEPARATOR . strtolower(parent::getController()) . '.php';

            if (file_exists($path)) {
                $controller = __NAMESPACE__ . '\\' . self::ROOT_DIR_CONTROLLERS . '\\' . ucfirst(strtolower(parent::getController()));
            } else {
                Response::BadRequest(Loc::getMessage('CLASS_NOT_FOUND', ['#OBJECT#' => ucfirst(parent::getController())]));
            }
        }

        $controllerObject = new $controller();

        if (method_exists($controllerObject, parent::getAction())) {

            // Request to log
            if (parent::getParameter()->getValue('SUPPORT_USE_LOG') == 'Y') {

                $pathLog = $_SERVER['DOCUMENT_ROOT'] . parent::getParameter()->getValue('SUPPORT_LOG_PATH');

                if (is_file($pathLog)) {

                    file_put_contents($pathLog, print_r(Request::get(), 1), FILE_APPEND | LOCK_EX);
                }
            }

            // Start action
            $action = parent::getAction();
            $controllerObject->$action();
        } else {

            Response::BadRequest(Loc::getMessage('METHOD_NOT_FOUND', ['#OBJECT#' => ucfirst(parent::getController()), '#METHOD#' => parent::getAction()]));
        }
    }
}