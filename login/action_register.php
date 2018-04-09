<?php
require "../config/config.php";

/********* Connexion de la Base de données associées *********/
try {
    $db_myql_login = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../resources/css/style.css?v=201801251000' />";
echo "<link rel='stylesheet' href='../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../resources/css/bootstrap.min.css'>";
echo "<link rel='shortcut icon' href='../resources/assets/data_favicon.png' />";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index_for_register()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";

/****************************************** Page ******************************************/

$data_today = date("Y-m-d");

$civilite = $_POST['reg_civilite'];
$firstname = $_POST['reg_firstname'];
$lastname = $_POST['reg_lastname'];
$pwd_orig = $_POST['reg_pswd'];
$email = $_POST['reg_email'];
$mobile = $_POST['reg_mobile'];
$pwd_hash = password_hash($pwd_orig, PASSWORD_BCRYPT);

if ($civilite == 0) {
    $civ = "Monsieur";
}
else {
    $civ = "Madame";
}

$db_register_email = $db_myql_login->prepare("SELECT email FROM ta_users WHERE email='$email'");
$db_register_email->execute();
$res = $db_register_email->fetch(PDO::FETCH_ASSOC);

if (gettype($res) == "array") {
    echo "<div class='content'>";
    echo "<div class='reg_success_title text-rouge'>L'adresse E-mail est déjà enregistrée !</div>";
    echo "<div class='reg_success_content'>Veuillez contacter l'administrateur pour changer votre mot de passe.</div>";
    echo "</div>"; //content
}
else if (!$res){
    echo "<div class='content'>";
    echo "<div class='reg_success_title'>Bonjour $civ $firstname $lastname</div>";
    echo "<div class='reg_success_content'>Vous vous êtes enregistré avec succès !</div>";
    echo "</div>"; //content
    $db_register = $db_myql_login->prepare("INSERT INTO ta_users (civilite, firstname, lastname, password, email, mobile, dtreg) VALUES ($civilite ,'$firstname', '$lastname', '$pwd_hash', '$email', '$mobile', '$data_today')");
    $db_register->execute();
    echo "<div class='reg_tips text-rouge'>Redirect dans 5 secondes ...</div>";
    echo "<meta http-equiv='refresh' content='5; url=../welcome.php'>";
}

/* $res_pwd = $res["password"];
if (password_verify($pwd_orig, $res_pwd)) {
    echo "yes";
} else {
    echo "no";
} */