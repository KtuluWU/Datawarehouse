<?php
// error_reporting(E_ALL || ~E_NOTICE);
require "../../config/config.php";

try {
    $dbmysql = new PDO($mysql_pdo_conn_hostdb, $mysql_pdo_conn_user, $mysql_pdo_conn_password);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

$query_day1 = $dbmysql->prepare("SELECT day2-day1 FROM (SELECT Nombre_saisies AS day1 FROM ta_entreprise_recu_histo WHERE Date='2017-11-12') a,
(SELECT Nombre_saisies AS day2 FROM ta_entreprise_recu_histo WHERE Date='2017-12-01') b");
$query_day1->execute();
$nombre_day1 = $query_day1->fetch(PDO::FETCH_NUM);
print_r($nombre_day1);
/*  while ($fetch_day1 = $query_day1->fetch(PDO::FETCH_ASSOC)) {
echo $fetch_day1["Nombre_saisies"];
}   */
//   print_r($nombre_day1);
