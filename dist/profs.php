<?php
require_once 'db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, SEARCH");
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
            $prof = json_decode(file_get_contents('php://input'), true);
            $parameters = [
                $prof['civilite'],
                $prof['nom'],
                $prof['prenom'],
                $prof['grade'],
                $prof['idprof'],
            ];
            if (!empty($prof['idprof']) && !empty($prof['civilite']) && !empty($prof['nom']) && !empty($prof['prenom'])) {
                $update = $mysqli->execute_query(
                    "UPDATE professeur SET civilite = ?, nom = ?, prenom = ?, grade = ? WHERE idprof = ?",
                    $parameters
                );
                echo json_encode(['status' => 'success']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error']);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'SEARCH') {
        $look = $_GET['look'];
        $look_name = '%'.$look.'%';
        $look_firstname = '%'.$look.'%';
        $professor = $mysqli->execute_query("SELECT * FROM professeur WHERE (idprof LIKE ? OR nom LIKE ? OR prenom LIKE ?)", [$look, $look_name, $look_firstname]);
        $prof_list = [];
        while ($row= $professor->fetch_assoc()) {
            $prof_list[] = $row;
        }
        echo json_encode($prof_list);
    }
    