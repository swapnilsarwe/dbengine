<?php

interface DBInterface
{

    static function getInstance ($arrConfig);

    function getData ($sql);

    function setData ($table, $arrData, $id);
}
?>