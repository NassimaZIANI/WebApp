<?php

//Include database configuration file
include('dbConfig.php');

if (isset($_POST["idMarque"]) && !empty($_POST["idMarque"])) {
    //Get all state data
    $query = $db->query("SELECT idModel, NomModel FROM model WHERE idMarque = " . $_POST['idMarque'] . " ORDER BY NomModel ASC");

    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display states list
    if ($rowCount > 0) {
        echo '<option value="">Sélectionner un modèle</option>';
        while ($row = $query->fetch_assoc()) {
            echo '<option value="' . $row['idModel'] . '">' . $row['NomModel'] . '</option>';
        }
    } else {
        echo '<option value="">modèle non-disponible</option>';
    }
}

if (isset($_POST["idModel"]) && !empty($_POST["idModel"])) {
    //Get all city data
    $query = $db->query("SELECT idMoteur, NomMoteur FROM moteur WHERE idModel = " . $_POST['idModel'] . " ORDER BY NomMoteur ASC");

    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display cities list
    if ($rowCount > 0) {
        echo '<option value="">Sélectionner un moteur</option>';
        while ($row = $query->fetch_assoc()) {
            echo '<option value="' . $row['idMoteur'] . '">' . $row['NomMoteur'] . '</option>';
        }
    } else {
        echo '<option value="">moteur non-disponible</option>';
    }
}
if (isset($_POST["idMoteur"]) && !empty($_POST["idMoteur"])) {
    //Get all city data
    $query = $db->query("SELECT idVehicule, Categorie, Annee FROM vehicule WHERE idMoteur = " . $_POST['idMoteur'] . " ORDER BY Categorie ASC");

    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display cities list
    if ($rowCount > 0) {
        echo '<option value="">Sélectionner un vehicule</option>';
        while ($row = $query->fetch_assoc()) {
            echo '<option value="' . $row['idVehicule'] . '">' . $row['Categorie'] . " " . $row['Annee'] . '</option>';
        }
    } else {
        echo '<option value="">vehicule non-disponible</option>';
    }
}
?>