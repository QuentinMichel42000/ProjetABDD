<?php
// Informations de connexion à Active Directory
$ldap_host = "ldap://WIN-RGIKC7QVOMI.MyGames.fr";
$ldap_port = 389;
$admin_username = "Admin@MyGames.fr";
$admin_password = "Motdepasse123";

// Récupérer l'utilisateur sélectionné
$selectedUsername = $_POST['Username'];

// Vérifier si la case est cochée
$isLocked = isset($_POST['maCase']) ? true : false;

// Connexion à Active Directory en tant qu'administrateur
$ldapconn = ldap_connect($ldap_host, $ldap_port) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
$ldapbind = ldap_bind($ldapconn, $admin_username, $admin_password);

// Recherche de l'utilisateur à modifier
$searchfilter = "(sAMAccountName=$selectedUsername)";
$searchresult = ldap_search($ldapconn, "dc=MyGames,dc=fr", $searchfilter);
$ldapresult = ldap_get_entries($ldapconn, $searchresult);

if ($ldapresult['count'] == 1) {
  // Modification du compte utilisateur
  $userdata = array();
  
  if ($isLocked) {
    // Désactivation du compte utilisateur
    $userdata['userAccountControl'] = '514'; // 514 = désactivation du compte
    $message = "Le compte utilisateur $selectedUsername a été désactivé avec succès.";
  } else {
    // Activation du compte utilisateur
    $userdata['userAccountControl'] = '512'; // 512 = activation du compte
    $message = "Le compte utilisateur $selectedUsername a été activé avec succès.";
  }
  $userdn = $ldapresult[0]['dn'];
  if (ldap_mod_replace($ldapconn, $userdn, $userdata)) {
    echo $message;
  } 
} 

ldap_close($ldapconn);
?>
