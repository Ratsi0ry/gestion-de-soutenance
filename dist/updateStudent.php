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

    if (!empty($data['matricule'])) {
        $matricule = $data['matricule'];
        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $niveau = $data['niveau'];
        $parcours = $data['parcours'];
        $adr_email = $data['adr_email'];
    
        $annee_univ = !empty($data['annee_univ']) ? trim($data['annee_univ']) : "";
        $note = (isset($data['note']) && $data['note'] !== '') ? intval($data['note']) : "";

        $sqlEtudiant = "UPDATE etudiant SET nom = ?, prenom = ?, niveau = ?, parcours = ?, adr_email = ? WHERE matricule = ?";
        $stmt1 = $mysqli->prepare($sqlEtudiant);
        $stmt1->bind_param("ssssss", $nom, $prenom, $niveau, $parcours, $adr_email, $matricule);
        $stmt1->execute();
        $stmt1->close();

        $checkSql = "SELECT matricule FROM soutenir WHERE matricule = ?";
        $checkStmt = $mysqli->prepare($checkSql);
        $checkStmt->bind_param("s", $matricule);
        $checkStmt->execute();
        $checkStmt->store_result();
        $existe = $checkStmt->num_rows > 0;
        $checkStmt->close();

        if ($existe) {
            $sqlSoutenir = "UPDATE soutenir SET annee_univ = ?, note = ? WHERE matricule = ?";
            $stmt2 = $mysqli->prepare($sqlSoutenir);
            $stmt2->bind_param("sis", $annee_univ, $note, $matricule);
        } else {
            $sqlSoutenir = "INSERT INTO soutenir (matricule, idorg, annee_univ, note) VALUES (?, 1, ?, ?)";
            $stmt2 = $mysqli->prepare($sqlSoutenir);
            $stmt2->bind_param("ssi", $matricule, $annee_univ, $note);
        }
        
        $stmt2->execute();
        $stmt2->close();

        echo json_encode(["status" => "success", "message" => "Étudiant et notes mis à jour avec succès !"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Matricule manquant."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Erreur : " . $e->getMessage()]);
}
?>