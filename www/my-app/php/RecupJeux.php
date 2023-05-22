<?php

require_once("../html/PageJeux.html");
require_once("connexionSQL.php");

// Vérification de la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;

// Nombre d'éléments par page
$elements_par_page = 10;

// Calcul de l'offset
$offset = ($page - 1) * $elements_par_page;

// Requête SQL pour récupérer les éléments limités à 10 éléments par page
$sql = "SELECT jeu_video.*, type_de_jeu.Nom AS type_nom, editeur.Nom AS editeur_nom 
        FROM jeu_video 
        JOIN type_de_jeu ON jeu_video.Type_de_jeu_id = type_de_jeu.id 
        JOIN editeur ON jeu_video.Editeur_Id = editeur.id 
        LIMIT $offset, $elements_par_page";
$resultat = mysqli_query($connexion, $sql);


// Récupération du nombre total d'éléments
$sql_total = "SELECT COUNT(*) as total FROM jeu_video";
$resultat_total = mysqli_query($connexion, $sql_total);
$donnees_total = mysqli_fetch_assoc($resultat_total);
$total_elements = $donnees_total['total'];

// Calcul du nombre total de pages
$nombre_de_pages = ceil($total_elements / $elements_par_page);

// Fermeture de la connexion à la base de données
mysqli_close($connexion);

?>