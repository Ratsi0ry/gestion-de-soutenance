<?php
require_once 'db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0); 
    }
    
    $get_professor = file_get_contents('php://input');
    $professor = json_decode($get_professor, true);
    
    if (!empty($professor['idprof']) && !empty($professor['nom']) && !empty($professor['prenom']) && !empty($professor['civilite']) && !empty($professor['grade'])) {
        try {
            $ask = $mysqli->prepare("SELECT idprof FROM professeur WHERE idprof = ?");
            $ask->bind_param('s', $professor['idprof']);
            $ask->execute();
            $ask->bind_result($exist);
            $ask->fetch();
        
            if ($exist) {
                echo json_encode(['status' => 'exist']);
                exit;
            } else {    
                $insert = "INSERT INTO professeur (idprof, nom, prenom, civilite, grade)
                           VALUES (?, ?, ?, ?, ?)";
                $mysqli->execute_query($insert, array_values($professor));
                echo json_encode(['status' => 'success']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e.getMessage()]);
        }
    }
