
<?php
session_start();

$val1 = $_SESSION['mdpanc'];
$val2 = $_SESSION['mailanc'];
$val3 = $_SESSION['username'];
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');

$listus = $bdd->query("SELECT * FROM utilisateur ORDER BY Username");
$listmar = $bdd->query("SELECT * FROM marque ORDER BY NomMarque");
$listmod = $bdd->query("SELECT * FROM model ORDER BY NomModel");
$listmot = $bdd->query("SELECT * FROM moteur ORDER BY NomMoteur");
$listveh = $bdd->query("SELECT * FROM vehicule ORDER BY Annee");

if (isset($_POST['numchasse']) && isset($_POST['anneeveh']) && isset($_POST['categorieveh'])) {
    $numchasse = $_POST['numchasse'];
    $anneeveh = $_POST['anneeveh'];
    $categorieveh = $_POST['categorieveh'];
    $selectedoption3 = $_POST['moteurVeh'];
    if ($anneeveh && $categorieveh) {

        $bdd->exec("INSERT INTO vehicule(idVehicule, NumChassis, Annee, Categorie, idMoteur) VALUES ('','$numchasse','$anneeveh','$categorieveh','$selectedoption3')");
        echo 'bien inserer';
    } else {
        echo 'veuillez saisir tout les champs';
    }
}

if (isset($_POST['moteur']) && isset($_POST['DescriptionMoteur'])) {
    $moteur = $_POST['moteur'];
    $desmot = $_POST['DescriptionMoteur'];
    $selectedoption2 = $_POST['model'];
    if ($moteur) {
        $bdd->exec("INSERT INTO moteur(idMoteur, NomMoteur, DescriptionMot, idModel) VALUES ('','$moteur','$desmot','$selectedoption2')");
        echo 'bien inserer';
    } else {
        echo 'veuillez saisir tout les champs';
    }
}
if (isset($_POST['ajoutModel']) && isset($_POST['DescriptionModel'])) {
    $model = $_POST['ajoutModel'];
    $desmod = $_POST['DescriptionModel'];
    $selectedoption = $_POST['marqueMod'];
    if ($model) {

        $bdd->exec("INSERT INTO model(idModel, NomModel, DescriptionMod, idMarque) VALUES ('','$model','$desmod','$selectedoption')");
        echo 'bien inserer';
    } else {
        echo 'veuillez saisir tout les champs';
    }
}
if (isset($_POST['modefier'])) {
    if (isset($_POST['username']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['daten']) && isset($_POST['adresse']) && isset($_POST['numtel']) && isset($_POST['email']) && isset($_POST['mdp'])) {
        $username = $_POST['username'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $daten = $_POST['daten'];
        $adresse = $_POST['adresse'];
        $numtel = $_POST['numtel'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        if ($username && $nom && $prenom && $daten && $adresse && $numtel && $email && $mdp) {
            if ($_POST['c-MDP'] != $_POST['mdp']) {
                echo 'les 2 mots de passe sont differents';
            } else {
                $longueur = strlen($mdp);

                if ($longueur < 8) {
                    echo "Mot de passe trop court !";
                } else {
                    if ($val1 && $val2) {
                        $bdd2 = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
                        $bdd2->query("UPDATE utilisateur SET Username='$username', NomUser='$nom', Prenom='$prenom', DateNais='$daten', Adresse='', NumTel='$numtel', Email='$email', MDP='$mdp' WHERE MDP='$val1' and Email='$val2'"); //
                        $r = $bdd2->query("SELECT * FROM utilisateur WHERE Email='$email'&& MDP=$mdp");
                        $do1 = $r->fetch();         //
                        if ($r->rowcount() == 1) {
                            $_SESSION['username'] = $do1['Username'];
                            $_SESSION['nomp'] = $do1['NomUser']; //
                            $_SESSION['prenomp'] = $do1['Prenom']; //  
                            $_SESSION['typep'] = $do1['TypeUser'];  // if($_SESSION['type']=='administrateur'){header('Location:admin.php');
                            $_SESSION['mdpancp'] = $do1['MDP']; //  
                            $_SESSION['mailancp'] = $do1['Email'];
                            $val11 = $_SESSION['mdpancp'];
                            $val22 = $_SESSION['mailancp'];
                        }
                    } else {
                        if (val11 && val22) {
                            $bdd2 = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
                            $bdd2->query("UPDATE utilisateur SET Username='$username', NomUser='$nom', Prenom='$prenom', DateNais='$daten', Adresse='', NumTel='$numtel', Email='$email', MDP='$mdp' WHERE MDP='$val11' and Email='$val22'");
                        } //
                        else {
                            echo 'ca na pa marché';
                        }
                    }
                }
            }
        }
    } else {
        echo 'veillez saisir tous les champs';
    }
}
if (isset($_POST['ref']) && isset($_POST['nompiece']) && isset($_POST['prix']) && isset($_POST['garantie']) && isset($_POST['dureegarantie']) && isset($_POST['statutpiece']) && isset($_POST['longueur']) && isset($_POST['largeur']) && isset($_POST['epaisseur']) && isset($_POST['poids']) && isset($_POST['description']) && isset($_POST['designation'])) {
    $ref = $_POST['ref'];
    $nompiece = $_POST['nompiece'];
    $prix = $_POST['prix'];
    $garantie = $_POST['garantie'];
    $dureegarantie = $_POST['dureegarantie'];
    $statutpiece = $_POST['statutpiece'];
    $longueur = $_POST['longueur'];
    $largeur = $_POST['largeur'];
    $epaisseur = $_POST['epaisseur'];
    $poids = $_POST['poids'];
    $description = $_POST['description'];
    $designation = $_POST['designation'];
    $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
    $user = $_SESSION['username'];



    if ($ref && $nompiece && $prix && $garantie && $dureegarantie && $statutpiece && $longueur && $largeur && $epaisseur && $poids && $description && $designation) {
        $bdd->exec("INSERT INTO pieces (idPub, Reference, NomPiece, Prix, Garantie, DureeGarantie, StatutPiece, Longueur, Largeur, Epaisseur, Poids, Description, Designation, Username) VALUES ('','$ref','$nompiece',$prix,'$garantie','$dureegarantie','$statutpiece',$longueur,$largeur,$epaisseur,$poids,'$description','$designation','$user')");
        echo 'bien inserer';
    } else {
        echo 'veuillez saisir tout les champs';
    }
}
?>

<html>
    <head> 
        <title>Mon profile</title>
        <link href="css/css/bootstrap.min.css" rel="stylesheet"> 

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery10.js"></script>
        <script src="js/jquery11.js"></script> 
        <script src="jquery.min.js"></script>
        <style>
            .custab{
                border: 1px solid #ccc;
                padding: 5px;
                margin: 5% 0;
                box-shadow: 3px 3px 2px #ccc;
                transition: 0.5s;
            }
            .custab:hover{
                box-shadow: 3px 3px 0px transparent;
                transition: 0.5s;
            }
        </style>
    </head>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#marque').on('change', function () {
                var marqueID = $(this).val();
                if (marqueID) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxData.php',
                        data: 'idMarque=' + marqueID,
                        success: function (html) {
                            $('#model').html(html);
                            $('#moteur').html('<option value="">Sélectionner un modèle avant</option>');
                        }
                    });
                } else {
                    $('#model').html('<option value="">Sélectionner une marque avant</option>');
                    $('#moteur').html('<option value="">Sélectionner un modèle avant</option>');
                }
            });

            $('#model').on('change', function () {
                var modelID = $(this).val();
                if (modelID) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxData.php',
                        data: 'idModel=' + modelID,
                        success: function (html) {
                            $('#moteur').html(html);
                        }
                    });
                } else {
                    $('#moteur').html('<option value="">Sélectionner un modèle avant</option>');
                }
            });

            $('#marqueVeh').on('change', function () {
                var marqueID = $(this).val();
                if (marqueID) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxData.php',
                        data: 'idMarque=' + marqueID,
                        success: function (html) {
                            $('#modelVeh').html(html);
                            $('#moteurVeh').html('<option value="">Sélectionner un modèle avant</option>');
                        }
                    });
                } else {
                    $('#modelVeh').html('<option value="">Sélectionner une marque avant</option>');
                    $('#moteurVeh').html('<option value="">Sélectionner un modèle avant</option>');
                }
            });

            $('#modelVeh').on('change', function () {
                var modelID = $(this).val();
                if (modelID) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxData.php',
                        data: 'idModel=' + modelID,
                        success: function (html) {
                            $('#moteurVeh').html(html);
                        }
                    });
                } else {
                    $('#moteurVeh').html('<option value="">Sélectionner un modèle avant</option>');
                }
            });
        });
    </script>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#navbar1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar1" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="Connecter.php">Accueil </a></li>
                    </ul>
                    <form method="GET" action="Rech.php" class="navbar-form navbar-left" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Chercher une piéce">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <a class="glyphicon glyphicon-search"></a>
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="glyphicon glyphicon-envelope" href="reception.php"></a> 
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <div class="text-center"><h5><b><?php
echo" " . $_SESSION['nom1'] . " " . $_SESSION['prenom1'];
?></b></h5></div>

                                <li><a href="Profile.php">Mon profil</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a class="glyphicon glyphicon-log-out" href="deconnecter.php"> Se déconnecter</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!--/.nav-collapse -->
        </nav>

        <div class="container-fluid" style="margin-top:50px">
            <div class="row">
                <div class="col-md-2" id="col2">
                    <div class="page-header"><h5 class="coll"><strong><i class="glyphicon glyphicon-user"></i>       Mon espace</strong></h5></div>

                    <p class="text-danger">
<?php
if (isset($_POST['modefier'])) {
    if ($_POST['username'] && $_POST['nom'] && $_POST['prenom'] && $_POST['daten'] && $_POST['adresse'] && $_POST['numtel'] && $_POST['email'] && $_POST['mdp']) {
        echo" Bienvenue " . $_POST['nom'] . " " . $_POST['prenom'];
    } else {
        echo "Bienvenue" . $_SESSION['nom1'] . " " . $_SESSION['prenom1'];
    }
} else {

    echo" Bienvenue " . $_SESSION['nom1'] . " " . $_SESSION['prenom1'];
}
?>    </p>
                    <p>
                        <?php
                        echo $_SESSION['type'];
                        ?> 
                    </p>
                    <div class="page-header"><h5 class="coll"><strong><i class="glyphicon glyphicon-info-sign"></i>       Mes information</strong></h5></div>
                    <ul class="nav nav-divider " > 
                        <li class="nav-item"><a href="#item9" role="tab" data-toggle="tab">Gérer les utilisateurs</a></li>
                        <li class="nav-item"><a href="#item5" role="tab" data-toggle="tab">Ajouter une marque</a></li>
                        <li class="nav-item"><a href="#item6" role="tab" data-toggle="tab">Ajouter un modèle</a></li>
                        <li class="nav-item"><a href="#item7" role="tab" data-toggle="tab">Ajouter un moteur</a></li>
                        <li class="nav-item"><a href="#item8" role="tab" data-toggle="tab">Ajouter un véhicule</a></li>
                        <li class="nav-item"><a href="#item2" role="tab" data-toggle="tab">Modifier les informations</a></li>
                        <li class="nav-item"><a href="#item1" role="tab" data-toggle="tab">Gérer les paramétres de configuration de l'application</a></li>
                    </ul>
                    <a href="deconnecter.php"  class="btn btn-xs btn-danger" name="deco">Déconnexion</a>
                </div>


                <div class="tab-content">
                    <div role="tabpanel" class="row-fluid tab-pane active" id="item9">
                        <div class="row col-md-6 col-md-offset-2 custyle">

                            <table class="table table-striped custab">


                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Statut</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
<?php
if ($listus->rowCount() > 0) {
    while ($lis = $listus->fetch()) {
        ?> 
                                        <tr>
                                            <td><?php echo $lis['Username']; ?></td>
                                            <td><?php echo $lis['Email']; ?></td>
                                            <td><?php echo $lis['StatutUser']; ?></td>
                                            <td class="text-center">
                                        <?php if ($lis['StatutUser'] == "Active") { ?>
                                                    <a class='btn btn-success btn-xs disabled' href="#"><span class="glyphicon glyphicon-ok"></span> Activer</a>
                                                    <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Bloquer</a>
        <?php } else if ($lis['StatutUser'] == "Bloqué") { ?>
                                                    <a class='btn btn-success btn-xs' href="#"><span class="glyphicon glyphicon-ok"></span> Activer</a>
                                                    <a href="#" class="btn btn-danger btn-xs disabled"><span class="glyphicon glyphicon-remove"></span> Bloquer</a>
                                                <?php } ?>
                                                <a href="#" class="btn btn-info btn-xs">Rendre modérateur</a></td>
                                        </tr>
                                            <?php } ?>
                                </table>


<?php } else { ?>
                                <p style="font-size: 50px"> Y'a aucun utilisateur</p>j
                                <?php } ?>
                        </div>
                    </div>

                    <div role="tabpanel" class="row-fluid tab-pane fade" id="item9">
                        <b style="font-size: 50px">En cours de développement...</b>
                    </div>
                    <div role="tabpanel" class="row-fluid tab-pane" id="item5">
                        <div class="col-md-8">
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="AjouterMarque.php">
                                    <div class="form-group row-fluid">
                                        <label  for="AjoutMarque" > Marque</label>
                                        <input  class="form-control" type="text" required type="text"  placeholder="indiquez le nom de la marque" id="ajoutMarque"  name="ajoutMarque">  
                                    </div> 
                                    <div class="form-group row-fluid">
                                        <label  for="description" > Description de la marque</label>
                                        <textarea rows=4 class="form-control"  id="description" name="description"></textarea>
                                    </div> 
                                    <button type="submit"  class="btn btn-primary offset1" name="ajout_marque">Ajouter</button>
                                </form>      
                            </div>
                        </div>
                        <div class="row col-md-6 col-md-offset-1 custyle">

                            <table class="table table-striped custab">
                                <thead>
                                    <tr>
                                        <th>ID marque</th>
                                        <th>Nom marque</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
<?php
if ($listmar->rowCount() > 0) {
    while ($lismar = $listmar->fetch()) {
        ?> 
                                        <tr>
                                            <td><?php echo $lismar['idMarque']; ?></td>
                                            <td><?php echo $lismar['NomMarque']; ?></td>
                                            <td><?php echo $lismar['DescriptionMar']; ?></td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Modifier</a>
                                                <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                        </tr>
    <?php } ?>
                                </table>


<?php } else { ?>
                                <p style="font-size: 50px"> Y'a aucune marque</p>j
                                <?php } ?>
                        </div>
                    </div>
                    <div role="tabpanel" class="row-fluid tab-pane" id="item6">
                        <div class="col-md-8">
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="Profile.php">
                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="Marque">Choisissez une marque</label>
                                        <div class="controls row-fluid">

<?php
//Include database configuration file
include('dbConfig.php');

//Get all marque data
$query = $db->query("SELECT idMarque, NomMarque FROM marque ORDER BY NomMarque ASC");

//Count total number of rows
$rowCount = $query->num_rows;
?>
                                            <select name="marqueMod" id="marqueMod" >
                                                <option value="">Sélectionner une marque</option>
                                            <?php
                                            if ($rowCount > 0) {
                                                while ($row = $query->fetch_assoc()) {
                                                    echo '<option value="' . $row['idMarque'] . '">' . $row['NomMarque'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">marque non-disponible</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label  for="AjoutModel" > Model</label>
                                        <input  class="form-control" type="text" required type="text"  placeholder="indiquez le nom du modèle" id="ajoutModel"  name="ajoutModel">  
                                    </div> 
                                    <div class="form-group row-fluid">
                                        <label  for="DescriptionModel" > Description de la marque</label>
                                        <textarea rows=4 class="form-control"  id="DescriptionModel" name="DescriptionModel"></textarea>
                                    </div> 
                                    <button type="submit"  class="btn btn-primary offset1" name="ajout_model">Ajouter</button>
                                </form>      
                            </div>
                        </div>
                        <div class="row col-md-6 col-md-offset-1 custyle">
                            <table class="table table-striped custab">
                                <thead>
                                    <tr>
                                        <th>ID modèle</th>
                                        <th>Nom modèle</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
<?php
if ($listmod->rowCount() > 0) {
    while ($lismod = $listmod->fetch()) {
        ?> 
                                        <tr>
                                            <td><?php echo $lismod['idModel']; ?></td>
                                            <td><?php echo $lismod['NomModel']; ?></td>
                                            <td><?php echo $lismod['DescriptionMod']; ?></td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Modifier</a>
                                                <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                        </tr>
    <?php } ?>
                                </table>


                                <?php } else { ?>
                                <p style="font-size: 50px"> Y'a aucun modèle</p>j
<?php } ?>
                        </div>
                    </div>
                    <div role="tabpanel" class="row-fluid tab-pane" id="item7">
                        <div class="col-md-8">
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="Profile.php">
                                    <div class="form-group row-fluid">
                                        <label  for="Marque" > Marque</label>
                                        <div class="controls row-fluid">

<?php
//Include database configuration file
include('dbConfig.php');

//Get all marque data
$query = $db->query("SELECT idMarque, NomMarque FROM marque ORDER BY NomMarque ASC");

//Count total number of rows
$rowCount = $query->num_rows;
?>
                                            <select name="marque" id="marque" >
                                                <option value="">Sélectionner une marque</option>
                                            <?php
                                            if ($rowCount > 0) {
                                                while ($row = $query->fetch_assoc()) {
                                                    echo '<option value="' . $row['idMarque'] . '">' . $row['NomMarque'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">marque non-disponible</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="Model">Choisissez un modèle </label>
                                        <div class="controls row-fluid">
                                            <select name="model" id="model">
                                                <option value="">Sélectionner une marque avant</option>
                                            </select>                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label  for="Moteur" > Moteur</label>
                                        <input  class="form-control" type="text" required type="text"  placeholder="indiquez le nom du moteur" id="moteur"  name="moteur">  
                                    </div> 
                                    <div class="form-group row-fluid">
                                        <label  for="descriptionMoteur" > Description du moteur</label>
                                        <textarea rows=4 class="form-control"  id="descriptionMoteur" name="DescriptionMoteur"></textarea>
                                    </div> 
                                    <button type="submit"  class="btn btn-primary offset1" name="ajout_moteur">Ajouter</button>
                                </form>
                            </div>
                        </div>
                        <div class="row col-md-6 col-md-offset-1 custyle">
                            <table class="table table-striped custab">
                                <thead>
                                    <tr>
                                        <th>ID moteur</th>
                                        <th>Nom moteur</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
<?php
if ($listmot->rowCount() > 0) {
    while ($lismot = $listmot->fetch()) {
        ?> 
                                        <tr>
                                            <td><?php echo $lismot['idMoteur']; ?></td>
                                            <td><?php echo $lismot['NomMoteur']; ?></td>
                                            <td><?php echo $lismot['DescriptionMot']; ?></td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Modifier</a>
                                                <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                        </tr>
    <?php } ?>
                                </table>


                                <?php } else { ?>
                                <p style="font-size: 50px"> Y'a aucun moteur</p>j
<?php } ?>
                        </div>
                    </div>
                    <div role="tabpanel" class="row-fluid tab-pane" id="item8">
                        <div class="col-md-8">
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="Profile.php">
                                    <div class="form-group row-fluid">
                                        <label  for="MarqueVeh" > Marque</label>
                                        <div class="controls row-fluid">

<?php
//Include database configuration file
include('dbConfig.php');

//Get all marque data
$query = $db->query("SELECT idMarque, NomMarque FROM marque ORDER BY NomMarque ASC");

//Count total number of rows
$rowCount = $query->num_rows;
?>
                                            <select name="marqueVeh" id="marqueVeh" >
                                                <option value="">Sélectionner une marque</option>
                                            <?php
                                            if ($rowCount > 0) {
                                                while ($row = $query->fetch_assoc()) {
                                                    echo '<option value="' . $row['idMarque'] . '">' . $row['NomMarque'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">marque non-disponible</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="ModelVeh">Choisissez un modèle </label>
                                        <div class="controls row-fluid">
                                            <select name="modelVeh" id="modelVeh">
                                                <option value="">Sélectionner une marque avant</option>
                                            </select>                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="MoteurVeh">Choisissez un moteur </label>
                                        <div class="controls row-fluid">
                                            <select name="moteurVeh" id="moteurVeh">
                                                <option value="">Sélectionner une modèle avant</option>
                                            </select>                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label  for="NumeroChasse" > Numéro Chassis</label>
                                        <input  class="form-control" type="text" type="text"  placeholder="indiquez le numéro de chassis" id="numchasse"  name="numchasse">  
                                    </div>

                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="Anneeveh">Choisissez une année </label>
                                        <div class="controls row-fluid">
                                            <select name="anneeveh" id="anneeveh">
                                                <option value="">Sélectionner une année</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label class="control-label" for="Categorieveh">Choisissez une catégorie </label>
                                        <div class="controls row-fluid">
                                            <select name="categorieveh" id="categorieveh">
                                                <option value="">Sélectionner une catégorie</option>
                                                <option value="citadine">Citadin</option>
                                                <option value="berline">Berline</option>
                                                <option value="familiale">Familiale</option>
                                                <option value="monospace">Monospace</option>
                                                <option value="cabriolet">Cabriolet</option>
                                                <option value="sportive">Sportive</option>
                                                <option value="hybride">Hybride</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group row-fluid">
                                        <div class="controls row-fluid">
                                            <button type="submit"  class="btn btn-primary offset1" name="ajout_veh">Ajouter</button>
                                        </div>
                                    </div>   
                                </form>
                            </div>
                        </div>
                        <div class="row col-md-6 col-md-offset-1 custyle">
                            <table class="table table-striped custab">
                                <thead>
                                    <tr>
                                        <th>ID véhicule</th>
                                        <th>Numéro chassis</th>
                                        <th>Année</th>
                                        <th>Catégorie</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
<?php
if ($listveh->rowCount() > 0) {
    while ($lisveh = $listveh->fetch()) {
        ?> 
                                        <tr>
                                            <td><?php echo $lisveh['idVehicule']; ?></td>
                                            <td><?php echo $lisveh['NumChassis']; ?></td>
                                            <td><?php echo $lisveh['Annee']; ?></td>
                                            <td><?php echo $lisveh['Categorie']; ?></td>
                                            <td class="text-center">
                                                <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Modifier</a>
                                                <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                        </tr>
    <?php } ?>
                                </table>


<?php } else { ?>
                                <p style="font-size: 50px"> Y'a aucune marque</p>j
                            <?php } ?>
                        </div>
                    </div>


                    <div role="tabpanel" class="row-fluid tab-pane" id="item2">
                        <div class="col-md-8">
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="profile.php">

                                    <div class="form-group row-fluid">
                                        <label  for="nom" > Nom</label>
                                        <input  class="form-control" type="text" id="nom" name="nom">  
                                    </div> 
                                    <div class="form-group row-fluid ">
                                        <label  for="prenom" > Prenom</label>
                                        <input  class="form-control input-xlarge" type="text" id="prenom" name="prenom">
                                    </div>
                                    <div class="form-group row-fluid ">
                                        <label  for="username" > Username</label>

                                        <input  class="form-control" type="text" id="username" name="username">
                                    </div>
                                    <div class="form-group row-fluid ">
                                        <label  for="numtel" > Numéro Téléphone</label>

                                        <input  class="form-control" type="tel" id="numtel" name="numtel" pattern="0(5|6|7)[0-9]{8}">
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label for="daten" > Date de naissance</label>

                                        <input  class="form-control" type=date id="daten" name="daten">
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label class="control-label " for="adresse" > Adresse</label>                                    
                                        <textarea rows=4 class="form-control"  id="adresse" name="adresse"></textarea>
                                    </div>
                                    <div class="form-group row-fluid ">
                                        <label  for="email"  >Email</label>

                                        <input  class="form-control" type=email id="email" name="email" placeholder="email@exemple.com">
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label  for="mdp" > Mot de passe</label>

                                        <input  class="form-control" type="password" id="mdp" name="mdp">
                                    </div>
                                    <div class="form-group row-fluid">
                                        <label  for="c-MDP" > confirmer le mot votre passe</label>                                   
                                        <input  class="form-control" type="password" id="c-MDP" name="c-MDP"> <br><br><br>
                                        <button type="submit"  class="btn btn-default" name="modefier"><i class="icon-lock">  </i> Valider</button>                                  
                                    </div>        
                                </form> </div>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div role="tabpanel" class="row-fluid tab-pane fade" id="item1">
                        <b style="font-size: 50px">En cours de développement...</b>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/js/jquery.js"></script>
        <script src="js/js/bootstrap.min.js"></script>
    </body>
</html>
