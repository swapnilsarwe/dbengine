<?php

class MySQLPDODB implements DBInterface
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
        $this->dbconn = new PDO(
                'mysql:host=' . $arrConfig['hostname'] . ';dbname=' .
                         $arrConfig['database'], $arrConfig['username'], 
                        $arrConfig['password']);
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
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $arrResult[] = $row;
        }
        
        return $arrResult;
    }

    public function setData ($arrData, $id)
    {}
}
?>