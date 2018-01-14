<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Artamonov\Api\Options;

Loc::loadMessages(__FILE__);

Loader::includeModule('artamonov.api');

$options = new Options();
$form = basename(__FILE__, '.php');

$tabControl = new CAdminTabControl(
    'tabControl',
    [
        ['DIV' => 'tab-1', 'TAB' => Loc::getMessage('TAB_MAIN_TITLE')]
    ]
);

$APPLICATION->SetTitle(Loc::getMessage('TITLE'));

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php';

if ($_POST) {
    $_POST['form'] = $form;
    if ($_POST['save']) {
        if ($options->save($_POST)) {
            echo CAdminMessage::ShowNote(Loc::getMessage('OPTIONS_SAVED'));
        }
    }
    if ($_POST['restore']) {
        if ($options->restore($_POST)) {
            echo CAdminMessage::ShowNote(Loc::getMessage('OPTIONS_RESTORED'));
        }
    }
}

$tabControl->Begin();
$tabControl->BeginNextTab();
?>
    <form method='POST' name='<?=$form?>' action='<?=$APPLICATION->GetCurUri()?>'>
        <?=bitrix_sessid_post()?>

        <tr>
            <td width='45%' valign='middle'><?=Loc::getMessage('OPTION_USE_RESTFUL_API')?><td>
            <td width='55%' valign='middle'>
                <?
                $ar = [
                    'REFERENCE' => [
                        Loc::getMessage('OPTION_USE_RESTFUL_API_SELECT_TITLE_1'),
                        Loc::getMessage('OPTION_USE_RESTFUL_API_SELECT_TITLE_2')
                    ],
                    'REFERENCE_ID' => [
                        Loc::getMessage('OPTION_USE_RESTFUL_API_SELECT_ID_1'),
                        Loc::getMessage('OPTION_USE_RESTFUL_API_SELECT_ID_2')
                    ]
                ];
                echo SelectBoxFromArray('OPTION_USE_RESTFUL_API', $ar, $options->getValue('USE_RESTFUL_API'), '', '', false, $options->getFormName());
                ShowJSHint(Loc::getMessage('OPTION_USE_RESTFUL_API_SELECT_HINT'));
                ?>
            <td>
        </tr>

        <tr>
            <td width='45%' valign='middle'><?=Loc::getMessage('OPTION_USE_VERSIONS')?><td>
            <td width='55%' valign='middle'>
                <?
                $ar = [
                    'REFERENCE' => [
                        Loc::getMessage('OPTION_USE_VERSIONS_SELECT_TITLE_1'),
                        Loc::getMessage('OPTION_USE_VERSIONS_SELECT_TITLE_2')
                    ],
                    'REFERENCE_ID' => [
                        Loc::getMessage('OPTION_USE_VERSIONS_SELECT_ID_1'),
                        Loc::getMessage('OPTION_USE_VERSIONS_SELECT_ID_2')
                    ]
                ];
                echo SelectBoxFromArray('OPTION_USE_VERSIONS', $ar, $options->getValue('USE_VERSIONS'), '', '', false, $options->getFormName());
                ShowJSHint(Loc::getMessage('OPTION_USE_VERSIONS_SELECT_HINT'));
                ?>
            <td>
        </tr>

        <tr>
            <td width='45%' valign='middle'><?=Loc::getMessage('OPTION_PATH_RESTFUL_API')?><td>
            <td width='55%' valign='middle'>
                <input type='text' name='OPTION_PATH_RESTFUL_API' size='9' value='<?=$options->getValue('PATH_RESTFUL_API')?>'>
                <?ShowJSHint(Loc::getMessage('OPTION_PATH_RESTFUL_HINT'))?>
            <td>
        </tr>

        <tr><td colspan="4">&nbsp;</td></tr>
        <tr><td colspan="4">&nbsp;</td></tr>

        <tr>
            <td width='45%' valign='middle'><?=Loc::getMessage('OPTION_OPERATING_MODE')?><td>
            <td width='55%' valign='middle'>
                <?
                $ar = [
                    'REFERENCE' => [
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_TITLE_1'),
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_TITLE_2'),
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_TITLE_3')
                    ],
                    'REFERENCE_ID' => [
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_ID_1'),
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_ID_2'),
                        Loc::getMessage('OPTION_OPERATING_MODE_SELECT_ID_3')
                    ]
                ];
                echo SelectBoxFromArray('OPTION_OPERATING_MODE', $ar, $options->getValue('OPERATING_MODE'), '', '', false, $options->getFormName());
                ShowJSHint(Loc::getMessage('OPTION_OPERATING_MODE_HINT'));
                ?>
            <td>
        </tr>

        <tr>
            <td colspan='4' valign='middle'>
                <?$tabControl->Buttons();?>
                <input type='submit' name='save' value='<?=Loc::getMessage('BTN_SAVE')?>' class='adm-btn-save'>
                <input type='submit' name='restore' value='<?=Loc::getMessage('BTN_RESTORE')?>'>
            </td>
        </tr>
    </form>
<?php
$tabControl->End();
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php';