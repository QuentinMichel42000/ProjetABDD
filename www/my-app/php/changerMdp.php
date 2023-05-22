<?php
// Récupération des données POST
$login = $_POST['login'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

$ldap_host = "ldap://WIN-RGIKC7QVOMI.MyGames.fr"; // ou ldaps:// pour une connexion sécurisée
$ldap_port = 389; // ou 636 pour une connexion sécurisée
$user_ldap_dn = "OU=Utilisateurs,DC=MyGames,DC=fr"; // DN de l'annuaire LDAP pour les utilisateurs
$admin_username = "admin@MyGames.fr"; // nom d'utilisateur complet pour le compte administrateur ayant les droits de l'AD
$admin_password = "Motdepasse123"; // mot de passe du compte administrateur ayant les droits de l'AD
$searchfilter = "(sAMAccountName=$login)";

// Connexion à l'Active Directory avec le compte administrateur
$ldapconn = ldap_connect($ldap_host, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
$ldapbind = ldap_bind($ldapconn, $admin_username, $admin_password);

// Recherche de l'utilisateur dans l'OU Utilisateurs
$searchresult = ldap_search($ldapconn, $user_ldap_dn, $searchfilter);
$ldapresult = ldap_get_entries($ldapconn, $searchresult);

if ($ldapresult['count'] == 1) {
  // Utilisateur trouvé, vérification du mot de passe actuel
  $userdn = $ldapresult[0]['dn'];
  if (ldap_bind($ldapconn, $userdn, $current_password)) {
    // Vérification du nouveau mot de passe
    if ($new_password == $confirm_password) {
      // Les mots de passe correspondent, remplacement du mot de passe
      $userdata = array('unicodePwd' => $new_password);
      if (ldap_mod_replace($ldapconn, $userdn, $userdata)) {
        echo "Le mot de passe a été mis à jour avec succès.";
      } else {
        echo "Impossible de mettre à jour le mot de passe.";
      }
    } else {
      echo "Les mots de passe ne correspondent pas.";
    }
  } else {
    echo "Le mot de passe actuel est incorrect.";
  }
} else {
  echo "L'utilisateur n'a pas été trouvé.";
}

// Fermeture de la connexion LDAP
ldap_close($ldapconn);
?>
