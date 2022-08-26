<?php

// fonction pour réciupérer l'utilisateur connecté
function getLoggedUser()
{
    if (isset($_SESSION["bookstore_logged_user"])) return $_SESSION["bookstore_logged_user"];
    else return false;
}

/**
 * fonction pour rediriger l'utilisateur 
 */

function redirect($page = "index.php")
{
   // On redirige vers la page d'accueil
   header("Location: $page");
   exit;
}

/**
 * fonction pour vérifier si l'utilisateur est un admin
 */

 function isAdmin()
 {
    $user = getLoggedUser();
    if(!$user || $user["role"] !== "admin") redirect();
 }

 /***
  * fonction pour rediriger si l'utilisateur n'est pas connecté
  */
  function isLogged()
{
  if (!getLoggedUser()) redirect();
}

?>