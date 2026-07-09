<?php
require_once 'db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0); 
    }
    $get_student = file_get_contents('php://input');
    $student = json_decode($get_student, true);

    if (!empty($student['matricule']) && !empty($student['nom']) && !empty($student['prenom']) && !empty($student['niveau']) && !empty($student['parcours']) && !empty($student['adr_email']) && !empty($student['civilite'])) {
        try {
            $ask = $mysqli->prepare("SELECT matricule FROM etudiant WHERE matricule = ?");
            $ask->bind_param('s', $student['matricule']);
            $ask->execute();
            $ask->bind_result($exist);
            $ask->fetch();

            if ($exist) {
                echo json_encode(['status' => 'exist']);
                exit;
            } else {
                $insert = "INSERT INTO etudiant (matricule, nom, prenom, niveau, parcours, adr_email, civilite) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
                $mysqli->execute_query($insert, array_values($student));
                echo json_encode(['status' => 'success']);
            }

        } catch (Exception $e) {
            echo json_encode ([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
