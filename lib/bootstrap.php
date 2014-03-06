<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once('vendor/autoload.php');
require_once('config.php');
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__), $isDevMode);

$conn = array(
    'driver' => 'pdo_mysql',
    'user' => $CFG->user,
    'password' => $CFG->pass,
    'dbname' => 'console'
);
        
$entityManager = EntityManager::create($conn, $config);    