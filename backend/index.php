<?php
/**
 * User: Vytenis Šlivinskas
 * Date: 2017-01-31
 * Time: 16:17
 */

//if(isset($_POST["teamType"])){

    $sql = "INSERT INTO `applicant` (`id`, `team_name_ID`, `full_name`, `email`, `vegetarian`, `birthday`, `phone_number`, `faculty`, `study_cycle`, `course`, `academic_group`, `cv_url`, `approved`) 
                VALUES (NULL, \'1\', \'Vardas Pavardė\', \'mano@pastas.lt\', \'1\', \'2017-01-04\', \'6698499549\', \'Elektronika\', \'Master\', \'Antras\', \'HMM-5\', \'labai graži nuoroda\', \'0\')";

    $db = new PDO('mysql:host=localhost;dbname=localhostDB;charset=utf8mb4', 'root', '');
    try {
        //connect as appropriate as above
        $db->query('hi'); //invalid query!
        echo "veikia";
    } catch(PDOException $ex) {
        echo "An Error occured!"; //user friendly message
        some_logging_function($ex->getMessage());
    }

print_r($_POST);
    
    $fields = array(
         "team_name_ID" =>  $teamName,
         "full_name" =>  $full_name   ,
         "email" =>  $email   ,
         "vegetarian" =>  $food   ,
         "birthday" =>  $birthday   ,
         "phone_number" =>  $phone,
         "faculty" =>  $faculty   ,
         "study_cycle" =>  $studyCycle   ,
         "course" =>  $course   ,
         "academic_group" =>  $acedemicGroup   ,
         "cv_url"  =>  $cvUrl
    );
//}


echo "Registracija";