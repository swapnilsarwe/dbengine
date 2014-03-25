<?php
require_once ('dblib/config.php');

$arrConfig = array(
        'hostname' => 'hostname',
        'username' => 'username',
        'password' => 'password',
        'database' => 'database',
        'port' => '3306'
);
// PDO Example
$db = DBFactory::Create('pdo', $arrConfig);
$arrResult = $db->getData('SELECT * FROM tablename LIMIT 5');
print_r($arrResult);

// MySQLi Example
$db = DBFactory::Create('mysqli', $arrConfig);
$arrResult = $db->getData('SELECT * FROM tablename LIMIT 5');
print_r($arrResult);

// MySQL Example
$db = DBFactory::Create('mysql', $arrConfig);
$arrResult = $db->getData('SELECT * FROM tablename LIMIT 5');
print_r($arrResult);
?>