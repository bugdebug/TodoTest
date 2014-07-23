<?
require("../init.php");

$res = Posts_PostMapper::getInstance()->getAll();

$a = new View_Index($res);
$a->display();