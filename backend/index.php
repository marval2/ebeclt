<?php
/**
 * User: Vytenis Šlivinskas
 * Date: 2017-01-31
 * Time: 16:17
 */
    include_once ("Validator.class.php");
    include_once ("EbecDB.class.php");
    include_once ("Mail.class.php");
    $configs = include_once ("_config.php");
    ini_set('post_max_size', '10M');
    ini_set('upload_max_filesize', '10M');

    $error = array();

    //TODO: Išsiaiškinti kaip padaryti testą su phpStorm

    /*$fields = array(
        "team_name_ID",
        "full_name",
        "email",
        "vegetarian",
        "birthday",
        "phone_number",
        "faculty",
        "study_cycle",
        "course",
        "academic_group",
        "cv_url"
    );*/

    function array_dup($ar){
        return array_unique(array_diff_assoc($ar,array_unique($ar)));
    }

    $valid = new Validator();
    $db = new EbecDB($configs->username,$configs->pass,$configs->database);
    try{
        $applicantsNumber = 0;
        if ($_SERVER['CONTENT_LENGTH'] > 8380000) {
            throw new Exception("Per dideli priedai/ To big file");
        }
        if(!empty($_POST["teamType"])){
            if($_POST["teamType"] == "caseStudyAlone"){
                $applicantsNumber = 1;
            }else{
                $applicantsNumber = 4;
                if(!empty($_POST["teamName"])){
                    if($db->isTeamInDB($_POST["teamName"])){
                        throw new Exception("Jau tokia komanda įregistruota/");
                    }
                }else{
                    throw new Exception("Įrašykite komandos pavadinimą/Team name is missing");
                }
            }
        }else{
            throw new Exception('Pasirinkite komandą/Chose team type');
        }

        for ($i = 0; $i< $applicantsNumber; $i++) {
            if (!empty($_POST["applicant" . $i . "_name"])) {
                $name = $_POST["applicant" . $i . "_name"];
                if($valid->isName($name)){
                    $fields[$i]["full_name"] = $name;
                }else {
                    throw new Exception('Blogai aprašytas vardas/Name is not valid');
                }
            }else{
                throw new Exception('Įrašykite savo vardą/Name is missing');
            }

            if (!empty($_POST["applicant" . $i . "_bird"])) {
                $date = $_POST["applicant" . $i . "_bird"];
                if($valid->isValidDate($date)){
                    $fields[$i]["birthday"] = $date;
                }else {
                    throw new Exception('Blogai nurodyta gimimo data/Date is incorrect');
                }
            }else{
                throw new Exception('Įrašykite datą/Chose birthday date');
            }

            $fields[$i]["vegetarian"] = isset($_POST["applicant" . $i . "__food"])? 1 : 0;

            if (!empty($_POST["applicant" . $i . "__email"])) {
                $email[$i] = $_POST["applicant" . $i . "__email"];
                if($valid->isEmail($email[$i])){
                    $fields[$i]["email"] = $email[$i];
                }else{
                    throw new Exception('Blogai nurodytas el. paštas/Email is incorrect');
                }
            }else{
                throw new Exception('Nurodykite el. pašto adresą/Write an email');
            }

            if($db->isEmailInDB($email[$i])){
                throw new Exception('Su tuo pačiu el. paštu jau yra registruotas asmuo/Person is already registered with this e-mail');
            }

            if (!empty($_POST["applicant" . $i . "_phone"])) {
                $phone = $_POST["applicant" . $i . "_phone"];
                if($valid->isPhoneNumber($phone)){
                    $fields[$i]["phone_number"] = $phone;
                }else{
                    throw new Exception('Blogai nurodytas telefono numeris/Phone number is incorrect');
                }
            }else{
                throw new Exception('Nurodykite telefono numerį/Write phone number');
            }

            if (!empty($_POST["applicant" . $i . "_faculty"])  ) {
                $faculty = $_POST["applicant" . $i . "_faculty"];
                $fields[$i]["faculty"] = $_POST["applicant" . $i . "_faculty"];
            }else{
                throw new Exception('Nurodykite savo fakultetą/Write study department');
            }
            if (!empty($_POST["applicant" . $i . "_study_cycle"])) {
                $fields[$i]["study_cycle"] = $_POST["applicant" . $i . "_study_cycle"];
            }else{
                throw new Exception('Nurodykite studijų pakopą/Write grade of education');
            }
            if (!empty($_POST["applicant" . $i . "_course"])) {
                $fields[$i]["course"] = $_POST["applicant" . $i . "_course"];
            }else{
                throw new Exception('Nurodykite studijų kursą/Study year');
            }
            if (!empty($_POST["applicant" . $i . "_academic_group"])) {
                $fields[$i]["academic_group"] = $_POST["applicant" . $i . "_academic_group"];
            }else{
                throw new Exception('Nurodykite akademinę grupę/Academic group');
            }
            if(isset($_FILES["applicant". $i ."_cv"])){
                if ($_FILES["applicant". $i ."_cv"]['error']!=0){
                    throw new Exception('Blogas failas. Įkelkite kitą/Incorrect file type. Available is pdf, doc, docx or otd');
                }else{
                    $cv[$i] = $_FILES["applicant". $i ."_cv"];
                }
                if(!$valid->isGoodFileFormat($cv[$i])){
                    throw new Exception('Blogas failo formatas arba neįkeltas failas/Incorrect cv file type. Available types is pdf, doc, docx or otd');
                }
                if (!$valid->isFileNotToBig($cv[$i])){
                    throw new Exception('Failas per didelis (įkelkite mažesnį nei 1MB)/CV file is too big');
                }
            }else{
                throw new Exception('Pridėkite failą/Add cv file');
            }
        }
        if($applicantsNumber == 4){
            $dubEmail = array($fields[0]["email"],$fields[1]["email"],$fields[2]["email"],$fields[3]["email"]);
            if(!empty(array_dup($dubEmail))){
                throw new Exception('Kartojasi el. paštas/Duplicate e-mails');
            }
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    try{
        if (!empty($_POST["teamName"])) {
            $teamId = $db->addTeam($_POST["teamName"], $_POST["teamType"]);
        } else {
            $teamId = 0;
        }
        $mail = new Mail();
        for ($i = 0; $i< $applicantsNumber; $i++) {
            $fields[$i]["team_name_ID"] = $teamId;
            $fileType = pathinfo($cv[$i]['name'],PATHINFO_EXTENSION);
            $target = 'cv/'.$email[$i].".".$fileType;
            $fields[$i]["cv_url"] = $target;
            move_uploaded_file( $cv[$i]["tmp_name"], $target);
            $db->addAplicant($fields[$i]);
            $mail->send($email[$i],"ebeckaunas@gmail.com");
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    echo "Registracija sėkminga! Kitas žingsnis sumokėti depozitą.
     Dėl depozitų perdavimo Studentų miestelyje kreiptis tel.: 862360723 (Emilija) dėl depozitų perdavimo centre kreiptis: 868662414 (Urtė)";
    exit();