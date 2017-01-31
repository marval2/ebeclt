<?php
/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-01-31
 * Time: 22:30
 */

function addAplicant($fields){
    $sql = "INSERT INTO `applicant` (`team_name_ID`, `full_name`, `email`, `vegetarian`, `birthday`, `phone_number`, `faculty`, `study_cycle`, `course`, `academic_group`, `cv_url`, `approved`) 
                VALUES ( :team_name_ID, :full_name, :email, :vegetarian, :birthday, :phone_number, :faculty, :study_cycle, :course, :academic_group, :cv_url, :approved)";

    $db = new PDO('mysql:host=localhost;dbname=localhostDB;charset=utf8mb4', 'root', '');
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":team_name_ID",  $fields["team_name_ID"]    );
        $stmt->bindParam(":full_name",     $fields["full_name"]       );
        $stmt->bindParam(":email",         $fields["email"]           );
        $stmt->bindParam(":vegetarian",    $fields["vegetarian"]      );
        $stmt->bindParam(":birthday",      $fields["birthday"]        );
        $stmt->bindParam(":phone_number",  $fields["phone_number"]    );
        $stmt->bindParam(":faculty",       $fields["faculty"]         );
        $stmt->bindParam(":study_cycle",   $fields["study_cycle"]     );
        $stmt->bindParam(":course",        $fields["course"]          );
        $stmt->bindParam(":academic_group",$fields["academic_group"]  );
        $stmt->bindParam(":cv_url" ,       $fields["cv_url" ]         );

        echo "veikia";
    } catch(PDOException $ex) {
        echo "An Error occured!"; //user friendly message
        some_logging_function($ex->getMessage());
    }
}

function renderErrors($errors){
    return "Klaidos";
}