<?php

// Paramètres de connexion LDAP
$ldap_host = "ldap://WIN-RGIKC7QVOMI.MyGames.fr"; 
$ldap_port = 389; // ou 636 pour une connexion sécurisée
$ldap_dn = "DC=MyGames,DC=fr"; // DN de l'annuaire LDAP
$ldap_user = $username . "@Mygames.fr"; // nom d'utilisateur complet
$ldap_password = $password; // mot de passe de l'utilisateur

// Connexion au serveur LDAP
$ldapconn = ldap_connect($ldap_host, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");

// Configuration des options LDAP
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

?>