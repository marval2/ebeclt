<?php
/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-02
 * Time: 21:47
 */
function renderApplicantList($data)
{
    $table = new Table();

    $server = $_SERVER["HTTP_HOST"];


    $i = 1;
    $table->prideti(0, 0, "Komandos pavadinimas");
    $table->prideti(0, 1, "Komandos tipas");
    $table->prideti(0, 2, "Vardas");
    $table->prideti(0, 3, "El. paštas");
    $table->prideti(0, 4, "Vegetaras");
    $table->prideti(0, 5, "Gimtadienis");
    $table->prideti(0, 6, "Telefonas");
    $table->prideti(0, 7, "Fakultetas");
    $table->prideti(0, 8, "Studijų pakopa");
    $table->prideti(0, 9, "Kursas");
    $table->prideti(0, 10, "Akademinė grupė");
    $table->prideti(0, 11, "CV");
    $table->prideti(0, 12, "Patvirtintas");
    foreach ($data as $row) {
        $checked = "";
        if ($row["approved"] > 0) {
            $checked = "checked";
        }
        $vegetarian = $row["vegetarian"] == 1 ? "Taip" : "Ne";
        switch ($row["teamType"]) {
            case "teamDesign" :
                $teamType = "Team design";
                break;
            case "caseStudy" :
                $teamType = "Case study";
                break;
            default :
                $teamType = "Case study (Vienas)";
        }

        // $table->trAttr($i, "id=".)
        // $table->trApglebti($i,"<form method='post'><input type='hidden' name='id' value='id_{$row["id"]}'>","</form>");
        $table->trAttr($i, ' id="id_' . $row["applicant_id"] . '""');
        $table->prideti($i, 0, $row["name"]);
        $table->prideti($i, 1, $teamType);
        $table->prideti($i, 2, $row["full_name"]);
        $table->prideti($i, 3, $row["email"]);
        $table->prideti($i, 4, $vegetarian);
        $table->prideti($i, 5, $row["birthday"]);
        $table->prideti($i, 6, "+3706" . $row["phone_number"]);
        $table->prideti($i, 7, $row["faculty"]);
        $table->prideti($i, 8, $row["study_cycle"]);
        $table->prideti($i, 9, $row["course"]);
        $table->prideti($i, 10, $row["academic_group"]);
        $table->prideti($i, 11, '<a href="http://' . $server . '/backend/' . $row["cv_url"] . '" download>cv</a>');
        $table->prideti($i, 12, "<input class='approve' id='approve_{$row["applicant_id"]}' type='checkbox' {$checked}>");
        $i++;
    }
    return $table->spausdinti();
}