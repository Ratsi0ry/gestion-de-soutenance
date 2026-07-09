<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php';

try {
    $mysqli->set_charset("utf8");

    $result = $mysqli->query("SELECT matricule, nom, prenom, niveau, parcours, adr_email, annee_univ, note FROM vue_details_soutenance");
    
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
    $mysqli->close();
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>