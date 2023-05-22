<?php
session_name("authenticated");
// démarrage de la session
session_start();

// récupération des données POST
$username = $_POST['username'];
$password = $_POST['password'];
$isAdmin = $_POST['isAdmin'];

require_once("connexionLDAP.php");

// Authentification de l'utilisateur
if ($ldapconn) {
    $ldapbind = ldap_bind($ldapconn, $ldap_user, $ldap_password);
    if ($ldapbind) {
        // Recherche de l'utilisateur dans les OU "Administrateurs" et "Utilisateurs"
        $searchdn = "OU=Administrateurs," . $ldap_dn;
        $searchfilter = "(sAMAccountName=$username)";
        $searchresult = ldap_search($ldapconn, $searchdn, $searchfilter);
        $adminuser = ldap_get_entries($ldapconn, $searchresult);

        $searchdn = "OU=Utilisateurs," . $ldap_dn;
        $searchfilter = "(sAMAccountName=$username)";
        $searchresult = ldap_search($ldapconn, $searchdn, $searchfilter);
        $useruser = ldap_get_entries($ldapconn, $searchresult);

        // Vérification de l'appartenance de l'utilisateur à un des OUs
        if ($adminuser['count'] > 0 || $useruser['count'] > 0) {
            // enregistrement de l'identifiant de l'utilisateur dans la session
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            // Vérification si il est admin pour plus tard
            if ($adminuser['count'] > 0) {
                $_SESSION['isAdmin'] = true;
            } else {
                $_SESSION['isAdmin'] = false;
            }
            header('Location: /my-app/html/PageJeux.html');
            exit();
        } else {
            echo "L'utilisateur n'appartient pas à l'OU 'Administrateurs' ou 'Utilisateurs'";
        }
    } else {
        echo "Erreur d'authentification : " . ldap_error($ldapconn);
    }
}

// Fermeture de la connexion LDAP
ldap_close($ldapconn);

?>
