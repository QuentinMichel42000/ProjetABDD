<?php
session_name("authenticated");
// Démarrage de la session
session_start();

// Paramètres de connexion LDAP
$ldap_host = "ldap://win-rgikc7qvomi.mygames.fr"; // ou ldaps:// pour une connexion sécurisée
$ldap_port = 389; // ou 636 pour une connexion sécurisée
$ldap_dn = "DC=MyGames,DC=fr"; // DN de l'OU à rechercher

// Vérification si l'utilisateur est connecté
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $ldap_user = $_SESSION['username'];
    $ldap_password = $_SESSION['password'];

    $ldapconn = ldap_connect($ldap_host, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldapbind = ldap_bind($ldapconn, $ldap_user, $ldap_password);

    if ($ldapbind) {
        $result = ldap_search($ldapconn, "OU=Utilisateurs,".$ldap_dn, "(objectClass=user)", array("name"));
        $entries = ldap_get_entries($ldapconn, $result);
    } else {
        echo "Erreur d'authentification : " . ldap_error($ldapconn);
    }
} else {
    echo "Vous devez être connecté pour accéder à cette page.";
}

// Fermeture de la connexion LDAP
ldap_close($ldapconn);
?>

