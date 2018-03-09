<?php
require "../config/config.php";

/********* Connexion de la Base de données associées *********/
try {
    $db_myql_login = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

$email = $_POST["email"];
$pwd = $_POST["pwd"];

$db_register_pwd = $db_myql_login->prepare("SELECT password FROM ta_users WHERE email='$email'");
$db_register_pwd->execute();

$res = $db_register_pwd->fetch(PDO::FETCH_ASSOC);

if (gettype($res) == "array") {
    $db_pwd = $res["password"];
    $pwd_verif = password_verify($pwd, $db_pwd);
    if ($pwd_verif) {
        echo "200";
    }
    else {
        echo "403";
    }
} else if (!$res) {
    echo "404";
}
