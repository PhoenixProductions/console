<?php
require($CFG->dirroot.'/vendor/autoload.php');
require($CFG->dirroot.'/lib/bootstrap.php');

require_once($CFG->dirroot.'/lib/AppManager.php');
require_once($CFG->dirroot.'/lib/OutputRenderer.php');
require_once($CFG->dirroot.'/lib/weblib.php');

//load entity Classes
require_once($CFG->dirroot.'/src/App.php');
require_once($CFG->dirroot.'/src/Config.php');

/**
 * Load configuration values from the DB.
 */
function get_config() {
    global $CFG;

    $originalCFG = clone($CFG);
    $cfgs = $originalCFG->em->getRepository('Config')->findAll();
//@TODO make only some settings loaded? the rest to load on the fly?
    unset($CFG);

    $CFG = new stdClass();
    foreach($cfgs as $c) {
	$name = $c->getName();
	$path = $c->getPath();
	if (empty($path)) {
	    if (!isset($CFG->$name)) {
		$CFG->$name = $c->getValue();
	    }
  	} else {
		$p = $c->getPath();
		if (!property_exists($CFG, $p)) {
			$CFG->$p = new stdClass();
		}
		$CFG->$p->$name = $c->getValue();
	}
    }
    //load from the DB;

    foreach(get_object_vars($originalCFG) as $name=>$value) {
	if (!isset($CFG->$name)) {
		$CFG->$name = $value;
  	}
    }

    return $CFG;
}


$OUTPUT = new OutputRenderer();
$APPMANAGER = new \Console\Applications\AppManager($CFG);

$CFG->em = $entityManager;
$CFG = get_config();

