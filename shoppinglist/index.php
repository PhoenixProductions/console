<?php
ini_set('display_errors',1);
require_once('../config.php');
require_once($CFG->dirroot.'/lib/setup.php');

$OUTPUT->shownavbar = true;

$app =\Console\Applications\AppManager::getAppInstance('shoppinglist');
//require_once('appinfo.php');
//$app = new app_shoppinglist(); 
$apps =  $app->getPanels();


$panel = '';
foreach($apps as $app) {

    $a = '';
    $a .= "<a href='{$app['path']}'>";
    $a .= "<div class='apppanel' style='";
/*
    if ($bgurl = $app->getPanelImage()) {
        $a .= "background-image:url(\"{$CFG->wwwroot}{$app->getPath()}/{$bgurl}$
    }
*/
    $a .= "'>";
    $a .= "<div class='apptitle'>{$app['name']}</div>";
    $a .= "</div>";
    $a .="</a>";
    $panel .= $a;
}
echo $OUTPUT->header();
echo $panel;
echo $OUTPUT->footer();
