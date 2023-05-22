<?php
require_once("connexionSQL.php");

// Vérification de la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

// Récupérer l'ID du jeu à supprimer
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête de suppression
    $sql = "DELETE FROM jeu_video WHERE id = $id";

    if ($connexion->query($sql) === TRUE) {
        echo "Jeu supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du jeu : " . $connexion->error;
    }

    // Fermer la connexion
    $connexion->close();
}
?>
