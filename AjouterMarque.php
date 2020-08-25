<?php

$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');

if (isset($_POST['ajoutMarque']) && isset($_POST['description'])) {
    $marque = $_POST['ajoutMarque'];
    $des = $_POST['description'];
    if ($marque) {
        $ajoutmarque = $bdd->query("INSERT INTO marque (NomMarque,DescriptionMar) VALUES ('$marque','$des')");
        header('Location:Profile.php');
    } else {
        echo 'veuillez saisir tout les champs';
    }
}
?>
