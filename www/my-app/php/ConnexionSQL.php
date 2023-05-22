<?php

// Paramètres de connexion SQL
$serveur = "localhost:3306";
$utilisateur = "root";
$mot_de_passe = "root";
$nom_base_de_donnees = "bdd_jeux";

// Connexion a SQL
$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);
if (!$connexion) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
