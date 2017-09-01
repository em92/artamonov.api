<?php


namespace Artamonov\Api;


use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

class Options
{
    const MODULE_ID = 'artamonov.api';
    const FORM_NAME = 'options';
    const OPTION_CODE_PREFIX = 'OPTION_';

    private $options;

    public function save($data)
    {
        $this->extractOptions($data);

        if ($ar = $this->getOptions()) {
            foreach ($ar as $code => $value) {

                switch ($code) {

                    case 'WHITE_LIST_ADDRESS':
                        $value = str_replace([' ', 'http://', 'https://'], '', $value);
                        break;
                    case 'BLACK_LIST_ADDRESS':
                        $value = str_replace([' ', 'http://', 'https://'], '', $value);
                        break;
                    default:
                        $value = trim($value);
                }

                Option::set($this->getModuleId(), $code, $value);
            }
            return true;
        }
    }

    public function restore()
    {
        Option::delete($this->getModuleId());
        return true;
    }

    private function extractOptions($data)
    {
        $arResult = [];

        if (!isset($data['OPTION_ONLY_HTTPS_EXCHANGE'])) {
            $data['OPTION_ONLY_HTTPS_EXCHANGE'] = 'N';
        }

        foreach ($data as $k => $v) {
            if (preg_match('/^'.self::OPTION_CODE_PREFIX.'/', strtoupper($k))) {
                $arResult[str_replace(self::OPTION_CODE_PREFIX, '', $k)] = $v;
            }
        }

        $this->setOptions($arResult);
    }

    public function getValue($option)
    {
        return Option::get($this->getModuleId(), $option);
    }

    public function getModuleId()
    {
        return self::MODULE_ID;
    }

    public function getFormName()
    {
        return self::FORM_NAME;
    }

    private function getOptions()
    {
        return $this->options;
    }

    private function setOptions($options)
    {
        $this->options = $options;
    }
}