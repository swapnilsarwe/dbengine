<?php

class MySQLDB implements DBInterface
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
        $this->dbconn = mysql_connect($arrConfig['hostname'], 
                $arrConfig['username'], $arrConfig['password']);
        if (! $this->dbconn) {
            die('Could not connect: ' . mysql_error());
        }
        $db_selected = mysql_select_db($arrConfig['database'], $this->dbconn);
        
        if (! $db_selected) {
            die(mysql_error());
        }
    }

    public function getData ($query)
    {
        $arrResult = false;
        if (DEBUGSQL) {
            echo '<!-- ' . $query . ' -->';
            // echo $query."<br />";
        }
        $starttime = time();
        $result = mysql_query($query);
        $endtime = time();
        $total_time = ($endtime - $starttime);
        
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $arrResult[] = $row;
            }
        }
        return $arrResult;
    }

    public function setData ($tablename, $arrData, $id = 0)
    {}
}
?>