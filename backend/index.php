<?php
/**
 * User: Vytenis Šlivinskas
 * Date: 2017-01-31
 * Time: 16:17
 */
    include_once ("Validator.class.php");
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

    try{
        $applicantsNumber = 0;
        if(isset($_POST["teamType"])){
            if($_POST["teamType"] == "caseStudyAlone"){
                $applicantsNumber = 1;
            }else{
                $applicantsNumber = 4;
            }
        }

        for ($i = 0; $i< $applicantsNumber; $i++) {
            $name = $_POST["applicant" . $i . "_name"];
            $date = $_POST["applicant" . $i . "_bird"];
            $food = $_POST["applicant" . $i . "__food"];
            $email = $_POST["applicant" . $i . "__email"];
            $phone = $_POST["applicant" . $i . "_phone"];
            $faculty = $_POST["applicant" . $i . "_faculty"];
            $study_cycle = $_POST["applicant" . $i . "_study_cycle"];
            $course = $_POST["applicant" . $i . "_course"];
            $academic_group = $_POST["applicant" . $i . "_academic_group"];

            if (isset($name) && !empty($name)) {
                if($valid->isName($name)){
                    $fields["full_name"] = $name;
                }else {
                    throw new Exception('Blogai aprašytas vardas');
                }
            }else{
                throw new Exception('Įrašykite savo vardą');
            }

            if (isset($date) && !empty($date)) {
                if($valid->isValidDate($date)){
                    $fields["birthday"] = $date;
                }else {
                    throw new Exception('Blogai nurodyta gimimo data');
                }
            }else{
                throw new Exception('Įrašykite datą');
            }
            if (isset($food)) {
                $fields["vegetarian"] = $food;
            }

            if (isset($email) && !empty($email)) {
                if($valid->isEmail($email)){
                    $fields["email"] = $email;
                }else{
                    throw new Exception('Blogai nurodytas el. paštas');
                }
            }else{
                throw new Exception('Nurodykite el. pašto adresą');
            }

            if (isset($phone) && !empty($phone)) {
                if($valid->isPhoneNumber($phone)){
                    $fields["phone_number"] = $phone;
                }else{
                    throw new Exception('Blogai nurodytas telefono numeris');
                }
            }else{
                throw new Exception('Nurodykite telefono numerį');
            }

            if (isset($faculty) && !empty($faculty) ) {
                $fields["faculty"] = $faculty;
            }else{
                throw new Exception('Nurodykite savo fakultetą');
            }

            if (isset($study_cycle) && !empty($study_cycle)) {
                $fields["study_cycle"] = $study_cycle;
            }else{
                throw new Exception('Nurodykite studijų pakopą');
            }

            if (isset($course) && !empty($course)) {
                $fields["course"] = $_POST["applicant" . $i . "_course"];
            }else{
                throw new Exception('Nurodykite studijų kursą');
            }

            if (isset($academic_group) && !empty($academic_group)) {
                $fields["academic_group"] = $academic_group;
            }else{
                throw new Exception('Nurodykite akademinę grupę');
            }
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

    try{
        //addAplicant();
    }catch (Exception $e){

    }

    echo "Registracijos pabaiga".$applicantsNumber;