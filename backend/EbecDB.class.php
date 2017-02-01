<?php

/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-01
 * Time: 03:49
 */
class EbecDB
{
    private $db;
    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=localhostDB;charset=utf8mb4', 'root', '');
    }

    /**
     * @param $fields
     */
    function addAplicant($fields){
        $sql = "INSERT INTO `applicant` (`team_name_ID`, `full_name`, `email`, `vegetarian`, `birthday`, `phone_number`, `faculty`, `study_cycle`, `course`, `academic_group`, `cv_url`) 
                VALUES ( :team_name_ID, :full_name, :email, :vegetarian, :birthday, :phone_number, :faculty, :study_cycle, :course, :academic_group, :cv_url)";
        print_r($fields);

        try {
            $stmt = $this->db->prepare($sql);
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
            $stmt->execute();
            echo "veikia";
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    /**
     * @param $email
     * @return bool
     */
    function isEmailInDB($email){
        $sql = "SELECT email FROM applicant WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email );
        $stmt->execute();
        if($stmt->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $teamName Komandos pavadinimas
     * @param $teamType Komandos tipas
     * @return int įrašytos komandos id
     */
    function addTeam($teamName, $teamType){
        $sql = "INSERT INTO `team`(`name`,`teamType`) VALUES (:team_name,:teamType)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":team_name",  $teamName );
        $stmt->bindParam(":teamType",  $teamType );
        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    function isTeamInDB($teamName){
        $sql = "SELECT `name` FROM team WHERE `name` = :team_name LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":team_name", $teamName );
        $stmt->execute();
        if($stmt->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

}