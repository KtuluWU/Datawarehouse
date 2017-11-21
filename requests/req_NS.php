<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);
require "../config/config.php";
require "../function_request.php";

/********* Connexion de la Base de données associées *********/
$db_conn_mysql = mysqli_connect($mysqli_host, $mysqli_dbusername, $mysqli_dbpassword, $mysqli_dbname);

/****************************************** Page ******************************************/
$date_ns1 = $_POST['date1'];
$date_ns2 = $_POST['date2'];

// if ($_POST['date_ns1'] != null && $_POST['date_ns2'] != null) {
  $sql_day1 = "SELECT DISTINCT Nombre_saisies FROM ta_entreprise_recu_histo WHERE Date='$date_ns1'";
  $sql_day2 = "SELECT DISTINCT Nombre_saisies FROM ta_entreprise_recu_histo WHERE Date='$date_ns2'";
  $query_day1 = mysqli_query($db_conn_mysql, $sql_day1);
  $query_day2 = mysqli_query($db_conn_mysql, $sql_day2);
  $nombre_day1 = mysqli_fetch_all($query_day1)[0][0];
  $nombre_day2 = mysqli_fetch_all($query_day2)[0][0];
  $nombre = $nombre_day2 - $nombre_day1;
  echo "Nombre saisies du <label class='text-rouge'>$date_ns1</label> à <label class='text-rouge'>$date_ns2</label>: <label class='text-blue'>$nombre</label>";
// }