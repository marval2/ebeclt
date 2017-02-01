<?php
/**
 * User: Vytenis Šlivinskas
 * Date: 2017-01-31
 * Time: 16:17
 */
    include_once ("Validator.class.php");
    include_once ("EbecDB.class.php");
    include_once ("temporay.php");
    $error = array();

    $fields = array(
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
    );

    $valid = new Validator();
    $db = new EbecDB();
    try{
        $applicantsNumber = 0;
        if(!empty($_POST["teamType"])){
            if($_POST["teamType"] == "caseStudyAlone"){
                $applicantsNumber = 1;
            }else{
                $applicantsNumber = 4;
                if(!empty($_POST["teamName"])){
                    if($db->isTeamInDB($_POST["teamName"])){
                        throw new Exception("Jau tokia komanda įregistruota");
                    }
                }else{
                    throw new Exception("Įrašykite komandos pavadinimą");
                }
            }
        }else{
            throw new Exception('Pasirinkite komandą');
        }

        for ($i = 0; $i< $applicantsNumber; $i++) {
            if (!empty($_POST["applicant" . $i . "_name"])) {
                $name = $_POST["applicant" . $i . "_name"];
                if($valid->isName($name)){
                    $fields[$i]["full_name"] = $name;
                }else {
                    throw new Exception('Blogai aprašytas vardas');
                }
            }else{
                throw new Exception('Įrašykite savo vardą');
            }

            if (!empty($_POST["applicant" . $i . "_bird"])) {
                $date = $_POST["applicant" . $i . "_bird"];
                if($valid->isValidDate($date)){
                    $fields[$i]["birthday"] = $date;
                }else {
                    throw new Exception('Blogai nurodyta gimimo data');
                }
            }else{
                throw new Exception('Įrašykite datą');
            }

            $fields[$i]["vegetarian"] = isset($_POST["applicant" . $i . "__food"])? 1 : 0;

            if (!empty($_POST["applicant" . $i . "__email"])) {
                $email = $_POST["applicant" . $i . "__email"];
                if($valid->isEmail($email)){
                    $fields[$i]["email"] = $email;
                }else{
                    throw new Exception('Blogai nurodytas el. paštas');
                }
            }else{
                throw new Exception('Nurodykite el. pašto adresą');
            }

            if($db->isEmailInDB($email)){
                throw new Exception('Su tuo pačiu el. paštu jau yra registruotas asmuo');
            }

            if (!empty($_POST["applicant" . $i . "_phone"])) {
                $phone = $_POST["applicant" . $i . "_phone"];
                if($valid->isPhoneNumber($phone)){
                    $fields[$i]["phone_number"] = $phone;
                }else{
                    throw new Exception('Blogai nurodytas telefono numeris');
                }
            }else{
                throw new Exception('Nurodykite telefono numerį');
            }

            if (!empty($_POST["applicant" . $i . "_faculty"])  ) {
                $faculty = $_POST["applicant" . $i . "_faculty"];
                $fields[$i]["faculty"] = $_POST["applicant" . $i . "_faculty"];
            }else{
                throw new Exception('Nurodykite savo fakultetą');
            }
            if (!empty($_POST["applicant" . $i . "_study_cycle"])) {
                $fields[$i]["study_cycle"] = $_POST["applicant" . $i . "_study_cycle"];
            }else{
                throw new Exception('Nurodykite studijų pakopą');
            }
            if (!empty($_POST["applicant" . $i . "_course"])) {
                $fields[$i]["course"] = $_POST["applicant" . $i . "_course"];
            }else{
                throw new Exception('Nurodykite studijų kursą');
            }
            if (!empty($_POST["applicant" . $i . "_academic_group"])) {
                $fields[$i]["academic_group"] = $_POST["applicant" . $i . "_academic_group"];
            }else{
                throw new Exception('Nurodykite akademinę grupę');
            }
            if(isset($_FILES["applicant". $i ."_cv"])){
                if ($_FILES["applicant". $i ."_cv"]['error']!=0){
                    throw new Exception('Blogas failas. Įkelkite kitą');
                }else{
                    $cv[$i] = $_FILES["applicant". $i ."_cv"];
                }
                if(!$valid->isGoodFileFormat($cv[$i])){
                    throw new Exception('Blogas failo formatas');
                }
                if (!$valid->isFileNotToBig($cv[$i])){
                    throw new Exception('Failas per didelis (įkelkite mažesnį nei 1MB)');
                }
            }else{
                throw new Exception('Pridėkite failą');
            }
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    try{

        if(!empty($_POST["teamName"])) {
            $teamId = $db->addTeam($_POST["teamName"],$_POST["teamType"]);
        }else{
            $teamId = 0;
        }
        for ($i = 0; $i< $applicantsNumber; $i++) {
            $fields[$i]["team_name_ID"] = $teamId;
            $fileType = pathinfo($cv[$i]['name'],PATHINFO_EXTENSION);
            $target = 'cv/'.$email.".".$fileType;
            $fields[$i]["cv_url"] = $target;
            move_uploaded_file( $cv[$i]["tmp_name"], $target);
            $db->addAplicant($fields[$i]);
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    echo "Registracijos pabaiga".$applicantsNumber;