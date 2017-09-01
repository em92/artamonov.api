<?php


namespace Artamonov\Api;


class Response
{
    private static function setHeaders()
    {
        header('Powered: Artamonov Denis Pro 2016-'.date('Y'));
        header('Support: http://artamonov.pro');
        header('Content-Type: application/json; charset=utf-8');
    }

    public static function ShowResult($data)
    {
        self::setHeaders();
        header('HTTP/1.0 200');
        echo json_encode(['status' => 200, 'result' => $data]);
        die();
    }

    public static function NoResult($errorText = '')
    {
        self::setHeaders();

        $errorText = ($errorText) ? $errorText : 'No Result';
        header('HTTP/1.0 200');
        echo json_encode(['status' => 200, 'error' => $errorText]);
        die();
    }

    public static function BadRequest($errorText = '')
    {
        self::setHeaders();

        $errorText = ($errorText) ? $errorText : 'Bad Request';
        header('HTTP/1.0 400');
        echo json_encode(['status' => 400, 'error' => $errorText]);
        die();
    }

    public static function DenyAccess()
    {
        self::setHeaders();
        header('HTTP/1.0 403');
        echo json_encode(['status' => 403, 'error' => 'Forbidden']);
        die();
    }
}