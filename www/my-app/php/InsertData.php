<?php

require_once("connexionSQL.php");

// Récupération des données du formulaire
$Nom = $_POST['Nom'];
$Prix = $_POST['Prix'];
$Date_de_sortie = $_POST['Date_de_sortie'];
$Image = addslashes(file_get_contents($_FILES['Image']['tmp_name']));

// Récupération de l'id de l'éditeur
$Editeur_Nom = $_POST['Editeur_Nom'];
$sql_editeur = "SELECT id FROM editeur WHERE Nom = '$Editeur_Nom'";
$resultat_editeur = mysqli_query($connexion, $sql_editeur);
$donnees_editeur = mysqli_fetch_assoc($resultat_editeur);
$Editeur_Id = $donnees_editeur['id'];

// Récupération de l'id du type de jeu
$Type_Nom = $_POST['Type_Nom'];
$sql_type = "SELECT id FROM type_de_jeu WHERE Nom = '$Type_Nom'";
$resultat_type = mysqli_query($connexion, $sql_type);
$donnees_type = mysqli_fetch_assoc($resultat_type);
$Type_Id = $donnees_type['id'];

// Requête SQL pour ajouter les données dans la table "Game"
$sql = "INSERT INTO jeu_video (Nom, Prix, Image, Editeur_Id, Type_de_jeu_Id, Date_de_sortie) VALUES ('$Nom', '$Prix', '$Image', '$Editeur_Id', '$Type_Id', '$Date_de_sortie')";
if (mysqli_query($connexion, $sql)) {
    header("Location: ../html/PageJeux.html");
    exit();
} else {
    echo "Erreur: " . mysqli_error($connexion);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
