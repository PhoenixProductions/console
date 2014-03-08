<?php
ini_set('display_errors',1);
require('../config.php');
require($CFG->dirroot.'/lib/setup.php');

echo $OUTPUT->header();
echo  '<img id="streamimage" class="xform" src="http://192.168.0.23:9000/?action=stream" />';

echo $OUTPUT->footer();
