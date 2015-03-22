<?php

// Variables de entorno de OpenShift
$dbhost = getenv("OPENSHIFT_MYSQL_DB_HOST");
$dbuser = getenv("OPENSHIFT_MYSQL_DB_USERNAME");

$dbpassword = getenv("OPENSHIFT_MYSQL_DB_PASSWORD");
$dbname = getenv("OPENSHIFT_APP_NAME");

// Conexion OpenShift
// mysql_connect($dbhost, $dbuser, $dbpassword) or die(mysql_error());
//mysql_select_db($dbname) or die(mysql_error());

// Conexion localhost
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("generador") or die(mysql_error());

$result = mysql_query("SELECT * FROM users") or die(mysql_error());

echo "<table border cellpadding=3>";
echo "<tr><td>Nombre Usuario</td>";
echo "<td>Direccion Email</td></tr>";

while ($currentRow = mysql_fetch_array($result))
{
	echo "<tr>";
	echo "<td>".$currentRow['username']."</td>";
	echo "<td>".$currentRow['email']."</td>";
	echo "</tr>";
}

echo "</table>";

?>