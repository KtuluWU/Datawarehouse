<?php 
require "./config/config.php";
session_start();
/********* Connexion de la Base de données associées *********/
try {
    $db_myql_login = new PDO($pg_pdo_conn_string_histo);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
}

if (isset($_SESSION['firstname'])) {
    echo "<meta http-equiv='refresh' content='0; url=./welcome.php'>";
}
/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='resources/css/style.css?v=201801251000' />";
echo "<link rel='stylesheet' href='resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='resources/css/bootstrap.min.css'>";
echo "<link rel='shortcut icon' href='resources/assets/data_favicon.png' />";
echo "<title> Datawarehouse </title>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo''></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";

/****************************************** Page ******************************************/
echo "<div class='content light'>";

echo "<div class='reg_title'>Connectez-vous</div>";
echo "<form id='form_login' name='form_login' action='' method='post'>";

echo "<div class='reg_input_div'>";
echo "<input class='reg_email_input reg_input' type='text' name='login_email' id='login_email' maxlength='30' placeholder='E-mail' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='reg_input_div'>";
echo "<input class='reg_pswd_input reg_input' type='password' name='login_pswd' id='login_pswd' maxlength='30' placeholder='Mot de passe' autocomplete='off' />";
echo "</div>"; // reg_input_div

echo "<div class='button_login_logout'>";
echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='button' id='button_login' value='Connecter' onClick='send_data_login()'>";
echo "<label><i class='material-icons icon-search'>send</i></label>";
echo "</div>"; //button_with_icon
echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='button' id='button_logout' value='Enregistrer' onClick='navigateTo_register()'>";
echo "<label><i class='material-icons icon-search'>input</i></label>";
echo "</div>"; //button_with_icon
echo "</div>"; //button_login_logout

echo "</form>";

echo "<div class='loadding_login no-padding' id='loadding_login'><img class='loadinggif' alt='Chargement...' src='resources/assets/loading_bl.gif'/></div>";
echo "<div class='response_login' id='response_login'></div>";

echo "</div>"; //content

echo "</div>"; // page
echo "<script src='resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='resources/javascript/javascript.js'></script>";
echo "<script src='resources/javascript/sweet-alert.js'></script>";
