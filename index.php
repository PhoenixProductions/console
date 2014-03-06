<?php
ini_set('display_errors',1);
require('config.php');
require($CFG->dirroot.'/lib/setup.php');

$OUTPUT->shownavbar = false;

if ($APPMANAGER->scan_for_new_apps() !== false ) {
    redirect('install.php');
}

$apps = $APPMANAGER->get_applications();

$panel = '';
foreach($apps as $app) {

    $a = '';
    $a .= "<a href='{$app->getPath()}'>";
    $a .= "<div class='apppanel' style='";
    if ($bgurl = $app->getPanelImage()) {
        $a .= "background-image:url(\"{$CFG->wwwroot}{$app->getPath()}/{$bgurl}\")';";
    }
    $a .= "'>";
    $a .= "<div class='apptitle'>{$app->getName()}</div>";
    $a .= "</div>";
    $a .="</a>";
    $panel .= $a;
}
echo $OUTPUT->header();
echo $panel;
echo $OUTPUT->footer();
