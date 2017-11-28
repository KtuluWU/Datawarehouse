<?php 
// error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);

require "config/config.php";
require "function_request.php";

/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='css/style.css' />";
echo "<link rel='stylesheet' href='css/bootstrap.min.css'>";
echo "<link rel='stylesheet' href='css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='css/zzsc.css'>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>";
echo "<div class='title_dibe light'>Commande DIBE</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='index.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";

/****************************************** Page ******************************************/

echo "<form id='form_dibe' name='form_dibe' action='' method='post' enctype='multipart/form-data' onSubmit='return check_dibe()'>"; //onSubmit='return check_siren()'
echo "<div class='total light'>";
echo "<div class='commande_dibe'>";

echo "<div class='titles_input relat'>";
echo "<div class='title_input'>Numéro Client : </div>";
echo "<div class='title_input'>Numéro utilisateur : </div>";
echo "<div class='title_input'>Mot de passe : </div>";
echo "<div class='title_input'>Référence : </div>";
echo "<div class='title_input'>Upload : </div>";
echo "</div>";// titles_input

echo "<div class='inputs_dibe relat'>";
echo "<div class='input_dibe'> <input class='input_text_dibe' type='text' name='input_dibe_nc' id='input_dibe_nc' maxlength='4' placeholder='4 chiffres' autocomplete='off'> </div>";
echo "<div class='input_dibe'> <input class='input_text_dibe' type='text' name='input_dibe_nut' id='input_dibe_nut' maxlength='4' placeholder='4 chiffres' autocomplete='off'> </div>";
echo "<div class='input_dibe'> <input class='input_text_dibe' type='password' name='input_dibe_mdp' id='input_dibe_mdp' placeholder='' autocomplete='off'> </div>";
echo "<div class='input_dibe'> <input class='input_text_dibe' type='text' name='input_dibe_ref' id='input_dibe_ref' maxlength='8' placeholder='8 lettres/chiffres' autocomplete='off'> </div>";
echo "<div class='input_dibe'> <input class='input_text_dibe_upload' type='file' name='input_dibe_csv' id='input_dibe_csv' accept='text/csv'> </div>";
echo "</div>";// inputs_dibe
echo "</div>"; // commande_dibe

echo "<div class='button_with_icon'>";
echo "<input class='button_chercher' type='submit' value='Commander' id='button_siren' onClick=''>";
echo "<label><i class='material-icons icon-search'>search</i></label>";
echo "</div>";

echo "</form>";
echo "</div>"; //saisir

$numclient = $_POST['input_dibe_nc']; 
$numutilis = $_POST['input_dibe_nut'];
$mdp = $_POST['input_dibe_mdp'];
$ref = $_POST['input_dibe_ref'];
$identification = $numclient.$numutilis."-".$mdp."-".$ref;


if ($numclient != null && $numutilis != null && $mdp != null && $_FILES["input_dibe_csv"]["type"] == "text/csv") {
    /* echo "n° client: $numclient</br>";
    echo "n° utilisateur: $numutilis</br>";
    echo "mot de passe: $mdp</br>";
    echo "référence: $ref</br>";
    echo "identification: $identification</br>"; */

    if ($_FILES["input_dibe_csv"]["error"] > 0)
    {
      echo "<div class='error_file'>Error: " . $_FILES["input_dibe_csv"]["error"] . "</div>";
    }
    else {
        $filename=$_FILES['input_dibe_csv']["name"];
        $type=$_FILES['input_dibe_csv']["type"];
        $tmp_name=$_FILES['input_dibe_csv']["tmp_name"];
        $size=$_FILES['input_dibe_csv']["size"];
        $error=$_FILES['input_dibe_csv']["error"];
        $url_file_mac_localhost = "/Users/yw/Website_Apache/associe/";
        $url_file_intranet = "./";
        $url_python_intranet = "C:/xampp/htdocs/associe/";
        move_uploaded_file($tmp_name, $url_file_mac_localhost."upload/".$filename);
        // move_uploaded_file($tmp_name, $url_file_intranet."upload/".$filename);
        
        // echo "Nom du fichier: <label class='text-rouge'>$filename</label><br>";

        $str_python = "sudo python ".$url_file_mac_localhost."dibe_pdf.py -i ".$identification." -f ".$url_file_mac_localhost."upload/".$filename." -d ".$url_file_mac_localhost."python";
        // $str_python = "sudo python ".$url_python_intranet."dibe_pdf.py -i ".$identification." -f ".$url_python_intranet."upload/".$filename." -d ".$url_python_intranet."python";
        exec($str_python);
        // echo "</br>Done!";
    }
}


echo "</div>"; // page
echo "<script src='javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='javascript/javascript.js'></script>";
echo "<script src='javascript/sweet-alert.js'></script>";