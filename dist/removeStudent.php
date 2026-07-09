<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    $bdd = new mysqli('localhost', 'root', 'connect123', 'gestion_soutenances');
    $bdd->set_charset("utf8");

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!empty($data['matricule'])) {
        $matricule = $data['matricule'];

        $bdd->query("SET FOREIGN_KEY_CHECKS = 0");

        $stmt1 = $bdd->prepare("DELETE FROM soutenir WHERE matricule = ?");
        $stmt1->bind_param("s", $matricule);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $bdd->prepare("DELETE FROM etudiant WHERE matricule = ?");
        $stmt2->bind_param("s", $matricule);
        $stmt2->execute();
        $stmt2->close();

        $bdd->query("SET FOREIGN_KEY_CHECKS = 1");

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Matricule manquant ou mal transmis."]);
    }

    $bdd->close();
} catch (Exception $e) {
    // Si ça plante, on réactive quand même la sécurité et on affiche l'erreur
    $bdd->query("SET FOREIGN_KEY_CHECKS = 1");
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>