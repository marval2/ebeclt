<?php
/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-01
 * Time: 12:23
 */

include_once("DepositDB.class.php");
include_once ("Table.class.php");
include_once ("renderApplicantTable.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(isset($_POST["login"])){
    if(!empty($_POST["user"]) && ! empty($_POST["pass"])){
        if($_POST["user"]== "kiekviena" && $_POST["pass"]== "mumSekasi84"){
            $_SESSION["prisijunges"] = "prisijungta";
            echo "Prisijungta";
        }else{
            echo "Blogas prisijungimo vardas arba slaptažodis";
        }
    }
}

if(empty($_SESSION["prisijunges"])){
    $content =  "
        <form method='post'>
    <input type='text' name='user' placeholder='Prisijungimo vardas'>
    <input type='password' name='pass' placeholder='Slaptažodis'>
    <input type='submit' name='login' value='Prisijungti'>
</form>
    ";
}else{
    $content = "";

    $config = include_once ("../_config.php");

    $db = new DeposidDB($config->username,$config->pass,$config->database);
    if(isset($_POST["id"]) && $_POST["id"] > 0){
        $config = include_once ("../_config.php");
        $checked = $_POST["approved"] == "true" ? 5 : 0;
        $rez = $db->updateAplicant($checked,$_POST["id"]);
        print "Rez:".$rez;
        if($rez === true){
            echo "Statusas pakeistas";
        }else{
            echo "Klaida:".$rez;
        }
        exit();
    }else {
        $content = renderApplicantList($db->applicantsList());
    }
}


?>

<html>
<head>
    <title>Apskaita</title>
    <link type="text/css" href="style.css" rel="stylesheet">

</head>
<body>
    <?php echo $content; ?>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>



