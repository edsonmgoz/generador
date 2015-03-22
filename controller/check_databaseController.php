<?php

if(!isset($_SESSION["database"]))
{
	header("Location: ".Conectar::ruta()."?accion=index");
}

require_once("model/indexModel.php");
$db = new Index();

$tables = $db->check_database();

require_once("view/check_database.phtml");
?>