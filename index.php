<?php
ini_set('display_errors',1);
require('config.php');
require($CFG->dirroot.'/lib/setup.php');

$OUTPUT->shownavbar = false;

if ($APPMANAGER->scan_for_new_apps() !== false ) {
    redirect('install.php');
}

$currentAppPath = get_param('app', 'string',false);
$curapp = false; //appInstance object
$apps = array();
if ($currentAppPath) {
	$curapp = \Console\Applications\AppManager::getAppInstance($currentAppPath);
	$action = get_param('action','string',false);
	if ($action !== false) {
		$action = strtolower($action);
		$result = $curapp->dispatch($action);
		if ($result === true) {
			//no change
		} else if ($result === false) {
			exit();	//app will deal with redirection
		} else if (is_string($result)) { //a string should be a URL redirect
			redirect($result);
			exit();
		}
	}

	$apps = $curapp->getPanels();
	$OUTPUT->shownavbar = true;
} else {
	$apps = $APPMANAGER->get_applications();
}

$panel = '';
foreach($apps as $app) {
    $isApp = is_a($app, 'App');
    $a = '';
    if ($isApp) {
        $a .= "<a href='?app={$app->getPath()}'>";
    } else {
	$app = (object)$app;

        $a .= "<a href='?app={$currentAppPath}&action={$app->action}'>";

    }
    $a .= "<div class='apppanel' style='";
    if ($isApp && $bgurl = $app->getPanelImage()) {
        $a .= "background-image:url(\"{$CFG->wwwroot}{$app->getPath()}/{$bgurl}\")';";
    }
    $a .= "'>";
    if ($isApp) {
    $a .= "<div class='apptitle'>{$app->getName()}</div>";
    } else {
    	$a .= "<div class='apptitle'>{$app->name}</div>";
    }
    $a .= "</div>";
    $a .="</a>";
    $panel .= $a;
}
echo $OUTPUT->header();
echo $panel;
echo $OUTPUT->footer();
