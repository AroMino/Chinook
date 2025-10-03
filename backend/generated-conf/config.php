<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion(2);
$serviceContainer->setAdapterClass('default', 'pgsql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle('default');
$manager->setConfiguration(array (
  'dsn' => 'pgsql:host=localhost;port=5432;dbname=chinook',
  'user' => 'mit',
  'password' => '123456',
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$serviceContainer->setConnectionManager($manager);
$serviceContainer->setDefaultDatasource('default');
require_once __DIR__ . '/./loadDatabase.php';
