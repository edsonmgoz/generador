<?php

require_once("model/indexModel.php");
$db = new Index();

$table_detail = $db->check_table();


require_once("view/check_table.phtml");

?>