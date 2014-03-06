<?php
require('config.php');
require($CFG->dirroot.'/lib/setup.php');


$APPMANAGER->install_new_apps();

redirect('index.php');