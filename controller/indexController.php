<?php
if(isset($_SESSION["database"]))
{
	header("Location: ".Conectar::ruta()."?accion=check_database");
}

require_once("view/index.phtml");

?>