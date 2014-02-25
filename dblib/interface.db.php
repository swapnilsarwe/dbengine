<?php

interface DBInterface
{

    static function getInstance ($arrConfig);

    public function getData ($sql);

    public function setData ($table, $arrData, $id = 0);
}
?>