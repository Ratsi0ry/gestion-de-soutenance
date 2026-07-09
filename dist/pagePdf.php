<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $matr = trim($_GET['matr'] ?? '');
    if ($matr === '') {
        echo json_encode(['status' => 'error', 'message' => 'Matricule manquant']);
        exit;
    }
    
     $sql = "SELECT parcours, civilite, nom, prenom, note, president, examinateur, rapporteur_int, rapporteur_ext
            FROM vue_details_soutenance
            WHERE matricule = ?";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $matr);

        if ($stmt->execute()) {
            $row = $stmt->get_result()->fetch_assoc();
            if ($row) {
                echo json_encode(['status' => 'success', 'data' => [
                    'matricule' => $row['matricule'],
                    'civilite' => $row['civilite'] ? $row['civilite'] : 'M.',
                    'parcours' => $row['parcours'],
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'note' => $row['note'] !== null ? $row['note'] : '',
                    'president' => $row['president'] ? $row['president'] : 'Non spécifié',
                    'examinateur' => $row['examinateur'] ? $row['examinateur'] : 'Non spécifié',
                    'rapporteur_int' => $row['rapporteur_int'] ? $row['rapporteur_int'] : 'Non spécifié',
                    'rapporteur_ext' => $row['rapporteur_ext'] ? $row['rapporteur_ext'] : ''
                ]]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Aucun étudiant trouvé']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'exécution de la requête']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur de préparation SQL']);
    }
}
?>