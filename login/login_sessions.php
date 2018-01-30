<?php
require "../config/config.php";
session_start();

try {
    $db_myql_login = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

$email = $_GET["useremail"];

$db_res = $db_myql_login->prepare("SELECT * FROM ta_users WHERE email='$email'");
$db_res->execute();

$res = $db_res->fetch(PDO::FETCH_ASSOC);

$res_civilite = $res["civilite"];
$res_firstname = $res["firstname"];
$res_lastname = $res["lastname"];
$res_mobile = $res["mobile"];
$res_dtreg = $res["dtreg"];

$_SESSION['civilite'] = $res_civilite;
$_SESSION['firstname'] = $res_firstname;
$_SESSION['lastname'] = $res_lastname;
$_SESSION['mobile'] = $res_mobile;
$_SESSION['dtreg'] = $res_dtreg;

echo "<meta http-equiv='refresh' content='0; url=../welcome.php'>";