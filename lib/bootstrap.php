<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array($CFG->dirroot.'/src'), $isDevMode);

$conn = array(
    'driver' => 'pdo_mysql',
    'user' => $CFG->user,
    'password' => $CFG->pass,
    'dbname' => 'console'
);
        
$entityManager = EntityManager::create($conn, $config);    