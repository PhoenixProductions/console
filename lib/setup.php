<?php
require($CFG->dirroot.'/vendor/autoload.php');
require($CFG->dirroot.'/lib/bootstrap.php');

//load entity Classes
require_once($CFG->dirroot.'/src/App.php');
function get_config() {
    global $CFG;
    return $CFG;
}

function redirect($url) {
    header('Location:'.$url);
    exit();
}
$CFG->em = $entityManager;

require_once($CFG->dirroot.'/lib/AppManager.php');
require_once($CFG->dirroot.'/lib/OutputRenderer.php');
$OUTPUT = new OutputRenderer();
$APPMANAGER = new \Console\Applications\AppManager($CFG);


