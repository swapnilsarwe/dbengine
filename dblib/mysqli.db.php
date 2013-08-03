<?php

class MySQLiDB implements DBInterface
{

    private static $instance;

    private $dbconn;

    public function __construct ($arrConfig)
    {
        $this->connectDB($arrConfig);
    }

    private function __clone ()
    {
        // do nothing (this overwrites the special PHP method __clone())
    }

    public static function getInstance ($arrConfig)
    {
        if (! (self::$instance instanceof self)) {
            self::$instance = new self($arrConfig);
        }
        return self::$instance;
    }

    private function connectDB ($arrConfig)
    {
        $db = new MySQLi($arrConfig['hostname'], $arrConfig['username'], 
                $arrConfig['password'], $arrConfig['database']);
        
        if ($db->connect_errno) {
            die($db->connect_error);
        }
        
        $this->dbconn = $db;
    }

    public function getData ($query)
    {
        $arrResult = false;
        if (DEBUGSQL) {
            echo '<!-- ' . $query . ' -->';
            // echo $query."<br />";
        }
        $starttime = time();
        $result = $this->dbconn->query($query);
        $endtime = time();
        $total_time = ($endtime - $starttime);
        
        if ($result->field_count > 0) {
            while ($row = $result->fetch_assoc()) {
                $arrResult[] = $row;
            }
        }
        return $arrResult;
    }

    public function setData ($tablename, $arrData, $id)
    {
        $strSQL = '';
        if ($id == 0) {
            // insert
            $startSQL = 'INSERT INTO ' . $tablename;
            $whereSQL = '';
        } else {
            // update
            $startSQL = 'UPDATE ' . $tablename;
            $whereSQL = 'WHERE id = ' . $id;
        }
        
        foreach ($arrData as $k => $v) {
            $arrSetSQL[] = '`' . $k . '`' . ' = "' .
                     $this->dbconn->real_escape_string(trim($v)) . '"';
        }
        $setSQL = 'SET ' . implode(', ', $arrSetSQL);
        
        $strSQL = $startSQL . ' ' . $setSQL . ' ' . $whereSQL;
        if (DEBUGSQL) {
            echo '<!-- ' . $strSQL . ' -->';
            // echo $strSQL."<br />";
        }
        $this->dbconn->query($strSQL);
        if ($id == 0) {
            // return mysql_insert_id($this->dbconn);
        }
    }
}
?>