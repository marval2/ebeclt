<?php

/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-01
 * Time: 03:49
 */
class DeposidDB
{
    private $db;
    function __construct($user,$pass,$database)
    {
        $this->db = new PDO('mysql:host=localhost;dbname='.$database.';charset=utf8mb4', $user, $pass);
    }


    /**
     * @param $deposit
     * @param $id
     * @return bool|string
     */
    function updateAplicant($deposit, $id){
        $sql = "UPDATE applicant SET approved = :approved WHERE id = :id";
        try {
            print $deposit;
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":approved",$deposit);
            $stmt->bindParam(":id", $id );
            $stmt->execute();
            return true;
        } catch(PDOException $ex) {
            return $ex->getMessage();
        }catch(Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * @return array
     */
    function applicantsList(){
        $sql = "SELECT applicant.id as applicant_id, team.id as team_id, team_name_ID, full_name,email,vegetarian,birthday,phone_number,faculty,study_cycle,course,academic_group,cv_url,approved,name,teamType
FROM applicant LEFT JOIN team ON team_name_ID = team.id";
        $stmt = $this->db->prepare($sql);
       // $stmt->bindParam(":team_name", $teamName );
        $stmt->execute();
        return $stmt->fetchAll();
    }

}