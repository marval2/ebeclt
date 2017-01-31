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
            if (isset($name)) {
                if($valid->isName($name)){
                    $fields["full_name"] = $name;
                }else {
                    throw new Exception('Blogai aprašytas vardas');
                }
            }
            if (isset($_POST["applicant" . $i . "_bird"])) {
            }
            if (isset($_POST["applicant" . $i . "__food"])) {
            }
            if (isset($_POST["applicant" . $i . "__email"])) {
            }
            if (isset($_POST["applicant" . $i . "_phone"])) {
            }
            if (isset($_POST["applicant" . $i . "_faculty"])) {
            }
            if (isset($_POST["applicant" . $i . "_study_cycle"])) {
            }
            if (isset($_POST["applicant" . $i . "_course"])) {
            }
            if (isset($_POST["applicant" . $i . "_academic_group"])) {
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