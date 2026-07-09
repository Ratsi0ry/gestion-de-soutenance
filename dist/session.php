<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0); 
}

require_once 'db.php';

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if(!empty($data['matr']) && !empty($data['idorg']) && !empty($data['room']) && !empty($data['years']) && !empty($data['design'])){
        
        $matr = $data['matr'];
        $idorg = intval($data['idorg']);
        $room = $data['room'];
        $years = $data['years'];
        $score = isset($data['score']) && $data['score'] !== '' ? intval($data['score']) : null;
        $design = $data['design'];
        
        $president = isset($data['president']) && trim($data['president']) !== '' ? trim($data['president']) : null;
        $examinateur = isset($data['examinateur']) && trim($data['examinateur']) !== '' ? trim($data['examinateur']) : null;
        $rapporteur_int = isset($data['rapporteur_int']) && trim($data['rapporteur_int']) !== '' ? trim($data['rapporteur_int']) : null;
        $rapporteur_ext = isset($data['rapporteur_ext']) && trim($data['rapporteur_ext']) !== '' ? trim($data['rapporteur_ext']) : null;

        $sqlOrg = "INSERT INTO organisme (idorg, design, lieu) VALUES (?, ?, ?) 
                   ON DUPLICATE KEY UPDATE design = VALUES(design), lieu = VALUES(lieu)";
        $stmtOrg = $mysqli->prepare($sqlOrg);
        $stmtOrg->bind_param("iss", $idorg, $design, $room);
        $stmtOrg->execute();
        $stmtOrg->close();
    
        $sqlSout = "INSERT INTO soutenir (matricule, idorg, annee_univ, note, president, examinateur, rapporteur_int, rapporteur_ext) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                        idorg = VALUES(idorg), 
                        annee_univ = VALUES(annee_univ), 
                        note = VALUES(note),
                        president = VALUES(president),
                        examinateur = VALUES(examinateur),
                        rapporteur_int = VALUES(rapporteur_int),
                        rapporteur_ext = VALUES(rapporteur_ext)";
                        
        $stmtSout = $mysqli->prepare($sqlSout);
        $stmtSout->bind_param("sisissss", $matr, $idorg, $years, $score, $president, $examinateur, $rapporteur_int, $rapporteur_ext);
        $stmtSout->execute();
        $stmtSout->close();

        echo json_encode([
            "status" => "success",
            "message" => "Session et membres du jury enregistrés avec succès !"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Veuillez remplir au moins le Matricule, l'Organisme, le Lieu et l'Année."
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur SQL ou Serveur : " . $e->getMessage()
    ]);
}
?>