<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Artamonov\Api\Options;

Loc::loadLanguageFile(__FILE__);

Loader::includeModule(Loc::getMessage('API_MODULE_ID'));

$options = new Options();

$tabControl = new CAdminTabControl(
    'tabControl',
    [
        ['DIV' => 'tab-1', 'TAB' => Loc::getMessage('TAB_MAIN_TITLE'), 'TITLE' => Loc::getMessage('TAB_MAIN_DESCRIPTION')],
        ['DIV' => 'tab-2', 'TAB' => Loc::getMessage('TAB_SECURITY_TITLE'), 'TITLE' => Loc::getMessage('TAB_SECURITY_DESCRIPTION')],
        ['DIV' => 'tab-3', 'TAB' => Loc::getMessage('TAB_SUPPORT_TITLE'), 'TITLE' => Loc::getMessage('TAB_SUPPORT_DESCRIPTION')]
    ]
);

$APPLICATION->SetTitle(Loc::getMessage('PAGE_TITLE').' "'.Loc::getMessage('API_MODULE_NAME').'"');

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php';

if ($_POST) {

    $data = &$_POST;

    if ($data['options-save']) {
        if ($options->save($data)) {
            echo CAdminMessage::ShowNote(Loc::getMessage('OPTIONS_SAVED'));
        }
    }

    if ($data['options-restore']) {
        if ($options->restore()) {
            echo CAdminMessage::ShowNote(Loc::getMessage('OPTIONS_RESTORED'));
        }
    }
}

if ($_GET['generateToken'] == 'Y') {
    $count = $options->generateTokens();

    if ($count > 0) {
        echo CAdminMessage::ShowNote(Loc::getMessage('TOKENS_GENERATED', ['#COUNT#' => $count]));
    }

}

$tabControl->Begin();
?>
    <form method='POST' name='<?=$options->getFormName()?>' action='<?=str_replace('&generateToken=Y', '', $APPLICATION->GetCurUri())?>'>

        <?php
        echo bitrix_sessid_post();

        $dir = __DIR__ . '/admin/options/tabs/';

        foreach ($tabControl->tabs as $tab) {

            if (is_file($path = $dir . $tab['DIV'] . '.php')) {

                $tabControl->BeginNextTab();
                require $path;
            }
        }
        ?>

        <tr>
            <td colspan='4' valign='middle'>
                <?$tabControl->Buttons();?>
                <input type='submit' name='options-save' value='<?=Loc::getMessage('BTN_OPTIONS_SAVE')?>' class='adm-btn-save'>
                <input type='submit' name='options-restore' value='<?=Loc::getMessage('BTN_OPTIONS_RESTORE')?>'>
            </td>
        </tr>
    </form>

<?php
$tabControl->End();

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';