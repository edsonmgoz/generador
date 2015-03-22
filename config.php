<?php
session_start();
class Conectar
{

	// Variables de entorno de OpenShift
	$dbhost = getenv("OPENSHIFT_MYSQL_DB_HOST");
	$dbuser = getenv("OPENSHIFT_MYSQL_DB_USERNAME");

	$dbpassword = getenv("OPENSHIFT_MYSQL_DB_PASSWORD");
	$dbname = getenv("OPENSHIFT_APP_NAME");

	// Conexion OpenShift
	// mysql_connect($dbhost, $dbuser, $dbpassword) or die(mysql_error());
	//mysql_select_db($dbname) or die(mysql_error());


	//Conexion a la base de datos
	public function con($database)
	{
		$con = mysql_connect($dbhost, $dbuser, $dbpassword) or die ('cannot connect to the database: ' . mysql_error());
		mysql_query("SET NAMES 'utf8'");
		$db_selected = mysql_select_db($database);
		if (!$db_selected)
		{
			session_destroy();
			header("Location: ".Conectar::ruta()."?accion=index&m=2");
			exit;
		}
		return $con;
	}
	public static function ruta()
	{
		return "http://generador-edsonmgoz.rhcloud.com/";
	}
	public function comillas_inteligentes($valor)
	{
		// Retirar las barras
		if (get_magic_quotes_gpc()) {
			$valor = stripslashes($valor);
		}

		// Colocar comillas si no es entero
		if (!is_numeric($valor)) {
			$valor = "'" . mysql_real_escape_string($valor) . "'";
		}
		return $valor;
	}
}
?>