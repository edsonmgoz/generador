<?php

require_once("model/indexModel.php");
$db = new Index();

$get_table_generator = $db->get_table_generator();

$get_column_generator = $db->get_column_generator();

if(isset($_POST["recordToVerify"]) and $_POST["recordToVerify"] == "si")
{
	$db->process();
}

require_once("view/fill_column.phtml");

?>