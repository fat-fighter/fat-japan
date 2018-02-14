<?php

include("db_controls.php");

$query = "SELECT COUNT(*) FROM Dictionary";

$db = new Db();
$result = $db -> select($query);

echo $result[0]["COUNT(*)"];
