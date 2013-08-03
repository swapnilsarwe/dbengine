<?php

class DBFactory
{

    public static function Create ($type, $arrConfig)
    {
        switch ($type) {
            case 'mysql':
                return MySQLDB::getInstance($arrConfig);
                break;
            
            case 'mysqli':
                return MySQLiDB::getInstance($arrConfig);
                break;
            
            case 'pdo':
                return MySQLPDODB::getInstance($arrConfig);
                break;
        }
    }
}
?>