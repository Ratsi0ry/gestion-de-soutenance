<?php
require_once 'db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0); 
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $professor = $mysqli->execute_query("SELECT * FROM professeur");
        $prof_list = [];
        while ($row= $professor->fetch_assoc()) {
            $prof_list[] = $row;
        }
        echo json_encode($prof_list);
    }
        
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {   
        try {
            $idprof = $_GET['idprof'];

            $delete = $mysqli->execute_query("DELETE FROM professeur WHERE idprof = ?", [$idprof]);
            echo json_encode(['status' => 'success']);

        } catch (Exception $e) {
            echo json_encode(['status' => 'error']);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $pr = json_decode(file_get_contents('php://input'), true);
            if (!empty($pr['idprof']) && !empty($pr['civilite']) && !empty($pr['nom']) && !empty($pr['prenom']) && !empty($pr['grade'])) {
                $update = $mysqli->execute_query(
                    "UPDATE TABLE professeur SET id = ?, civilite = ?, nom = ?, prenom = ?, grade = ? WHERE idprof = ?",
                    [...array_values($pr), $pr['idprof']]
                );
                echo json_encode(['status' => 'success']);
            }
            
        } catch (error) {
            echo json_encode(['status' => 'error']);
        }
    }
