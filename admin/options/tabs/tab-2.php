<?php

use Bitrix\Main\Localization\Loc;
?>

<tr>
    <td width='50%' valign='middle'><?=Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER')?><td>
    <td width='50%' valign='middle'>
        <?
        $ar = [
            'REFERENCE'    => [
                Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER_SELECT_TITLE_1'),
                Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER_SELECT_TITLE_2')
            ],
            'REFERENCE_ID' => [
                Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER_SELECT_ID_1'),
                Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER_SELECT_ID_2')
            ]
        ];
        echo SelectBoxFromArray('OPTION_USE_LIST_COUNTRY_FILTER', $ar, $options->getValue('USE_LIST_COUNTRY_FILTER'), '', '', false, $options->getFormName());
        ShowJSHint(Loc::getMessage('OPTION_USE_LIST_COUNTRY_FILTER_HINT'));
        ?>
    <td>
</tr>

<tr>
    <td width='45%' valign='top'><?=Loc::getMessage('OPTION_WHITE_LIST_COUNTRY_TITLE')?><td>
    <td width='55%' valign='middle'>
        <textarea name="OPTION_WHITE_LIST_COUNTRY" cols="50" rows="5"><?=$options->getValue('WHITE_LIST_COUNTRY')?></textarea>
        <?ShowJSHint(Loc::getMessage('OPTION_WHITE_LIST_COUNTRY_HINT'));?>
    <td>
</tr>


<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="4">&nbsp;</td></tr>


<tr>
    <td width='50%' valign='middle'><?=Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER')?><td>
    <td width='50%' valign='middle'>
        <?
        $ar = [
            'REFERENCE'    => [
                Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_TITLE_1'),
                Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_TITLE_2')
            ],
            'REFERENCE_ID' => [
                Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_ID_1'),
                Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER_SELECT_ID_2')
            ]
        ];
        echo SelectBoxFromArray('OPTION_USE_BLACK_LIST_ADDRESS_FILTER', $ar, $options->getValue('USE_BLACK_LIST_ADDRESS_FILTER'), '', '', false, $options->getFormName());
        ShowJSHint(Loc::getMessage('OPTION_USE_BLACK_LIST_ADDRESS_FILTER_HINT'));
        ?>
    <td>
</tr>

<tr>
    <td width='45%' valign='top'><?=Loc::getMessage('OPTION_BLACK_LIST_ADDRESS_TITLE')?><td>
    <td width='55%' valign='middle'>
        <textarea name="OPTION_BLACK_LIST_ADDRESS" cols="50" rows="10"><?=$options->getValue('BLACK_LIST_ADDRESS')?></textarea>
        <?ShowJSHint(Loc::getMessage('OPTION_BLACK_LIST_ADDRESS_HINT'));?>
    <td>
</tr>


<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="4">&nbsp;</td></tr>


<tr>
    <td width='50%' valign='middle'><?=Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER')?><td>
    <td width='50%' valign='middle'>
        <?
        $ar = [
            'REFERENCE'    => [
                Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_TITLE_1'),
                Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_TITLE_2')
            ],
            'REFERENCE_ID' => [
                Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_ID_1'),
                Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER_SELECT_ID_2')
            ]
        ];
        echo SelectBoxFromArray('OPTION_USE_WHITE_LIST_ADDRESS_FILTER', $ar, $options->getValue('USE_WHITE_LIST_ADDRESS_FILTER'), '', '', false, $options->getFormName());
        ShowJSHint(Loc::getMessage('OPTION_USE_WHITE_LIST_ADDRESS_FILTER_HINT'));
        ?>
    <td>
</tr>

<tr>
    <td width='45%' valign='top'><?=Loc::getMessage('OPTION_WHITE_LIST_ADDRESS_TITLE')?><td>
    <td width='55%' valign='middle'>
        <textarea name="OPTION_WHITE_LIST_ADDRESS" cols="50" rows="10"><?=$options->getValue('WHITE_LIST_ADDRESS')?></textarea>
        <?ShowJSHint(Loc::getMessage('OPTION_WHITE_LIST_ADDRESS_HINT'));?>
    <td>
</tr>