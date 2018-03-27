<?php 
error_reporting(E_ALL || ~E_NOTICE);
ini_set("max_execution_time", 0);

require "../../config/config.php";
require "../function_request.php";
session_start();
if (!isset($_SESSION['firstname'])) {
    echo "<meta http-equiv='refresh' content='0; url=../../index.php'>";
}
/****************************************** Title ******************************************/
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='../../resources/css/style.css' />";
echo "<link rel='stylesheet' href='../../resources/css/bootstrap.min.css'>";
echo "<link rel='stylesheet' href='../../resources/css/sweet-alert.css'>";
echo "<link rel='stylesheet' href='../../resources/css/zzsc.css'>";
echo "<link rel='shortcut icon' href='../../resources/assets/data_favicon.png' />";
echo "<title> Datawarehouse - DIBE </title>";
echo "</head>";
echo "<div class='page'>";
echo "<div class='title_logo dark'>";
echo "<div class='logo' onclick='navigateTo_index()'></div>";
echo "<div class='title_intranet'>Intranet Datawarehouse Datainfogreffe</div>";
echo "</div>"; // title_logo
echo "<div class='title_dibe light'>Commande DIBE</div>";
echo "<div class='back light'>";
echo "<a class='button_back' href='../../welcome.php'><i class='material-icons icon-back'>arrow_back</i>Back</a></div>";

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
echo "<input class='button_chercher' type='submit' value='Commander' id='button_siren'>";
echo "<label><i class='material-icons icon-search'>search</i></label>";
echo "</div>";
echo "</div>"; // total
echo "</form>";


$numclient = $_POST['input_dibe_nc']; 
$numutilis = $_POST['input_dibe_nut'];
$mdp = $_POST['input_dibe_mdp'];
$ref = $_POST['input_dibe_ref'];
$identification = $numclient.$numutilis."-".$mdp."-".$ref;

/****************************************** Functions *****************************************/

function unlink_dir_python() {
    $url_file = "../../";
    $file_python = $url_file."python";
    $handler = opendir($file_python);
    while (($filenamee = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况  
        if ($filenamee != "." && $filenamee != ".." && $filename != ".DS_Store") {  
                $files[] = $filenamee ;  
        }  
    }  
    closedir($handler); 
    foreach($files as $v) {
        unlink($url_file."python/$v");
    } 
}

function addFileToZip($path,$zip){
    $handler=opendir($path); //打开当前文件夹由$path指定。
    while(($filename=readdir($handler))!==false){
        if($filename != "." && $filename != ".." && $filename != ".DS_Store"){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                addFileToZip($path."/".$filename, $zip);
            }else{ //将文件加入zip对象
                $zip->addFile($path."/".$filename);
            }
        }
    }
    @closedir($path);
}
/**********************************************************************************************/

if ($numclient != null && $numutilis != null && $mdp != null) {

    if ($_FILES["input_dibe_csv"]["error"] > 0) {
      echo "<div class='error_file'>Error: " . $_FILES["input_dibe_csv"]["error"] . "</div>";
    }
    else {
        $filename=$_FILES['input_dibe_csv']["name"];
        $type=$_FILES['input_dibe_csv']["type"];
        $tmp_name=$_FILES['input_dibe_csv']["tmp_name"];
        $size=$_FILES['input_dibe_csv']["size"];
        $error=$_FILES['input_dibe_csv']["error"];
        $url_python_mac_locl = "/Users/yw/Website_Apache/associe/";
        $url_python_intranet = "C:/xampp/htdocs/associe/";
        $url_file = "../../";
        
        move_uploaded_file($tmp_name, $url_file."upload/".$filename);

        $str_python = "sudo python ".$url_python_mac_locl."dibe_pdf.py -i ".$identification." -f ".$url_python_mac_locl."upload/".$filename." -d ".$url_python_mac_locl."python";
        // $str_python = "python ".$url_python_intranet."dibe_pdf.py -i ".$identification." -f ".$url_python_intranet."upload/".$filename." -d ".$url_python_intranet."python";
        
        exec($str_python, $return_array, $coderetour);
        unlink($url_file."upload/$filename");

        /****************************************** Download *****************************************/
        
        $zip=new ZipArchive();
        $zip->open($url_file.'python_zip/python_resultats.zip', ZipArchive::OVERWRITE|ZipArchive::CREATE);
        addFileToZip($url_file.'python/', $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
        $zip->close(); //关闭处理的zip文件
        unlink_dir_python();      

        /****************************************** Résultat ******************************************/
        echo "<div class='resultat dark'>";
        
        echo "<div class='list_er button_with_icon'>";
        echo "<a class='list' href='../../python_zip/python_resultats.zip' target='_blank'>Export</a>";
        echo "<label><i class='material-icons icon-search'>file_download</i></label>";
        echo "</div>";

        echo "<div class='button_with_icon back_dibe'>";
        echo "<a class='button_chercher back_dibe' href='dibe_histo.php?nclient=$numclient&nutilisateur=$numutilis&ref=$ref&file=$filename&statut=$coderetour' target='_blank'>Historique</a>";
        echo "<label><i class='material-icons icon-search'>arrow_forward</i></label>";
        echo "</div>"; // button_with_icon

        echo "</div>"; // resultat
    }
}
echo "</div>"; // page
echo "<script src='../../resources/javascript/jquery-3.2.1.min.js'></script>";
echo "<script src='../../resources/javascript/javascript.js'></script>";
echo "<script src='../../resources/javascript/sweet-alert.js'></script>";