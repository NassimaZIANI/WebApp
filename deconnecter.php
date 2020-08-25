<?php

//connection au serveur
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
// Démarrage ou restauration de la session
session_start();

// Réinitialisation du tableau de session
// On le vide intégralement
$_SESSION = array();

// Destruction de la session
session_destroy();

// Destruction du tableau de session

unset($_SESSION);

unset($_COOKIE);
header("Cache-Control", "no-cache, no-store, must-revalidate");

header("Location:index.php");

exit;
?>

