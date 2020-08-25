
<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
if (isset($_SESSION['username'])) {


    $val1 = $_SESSION['mdpanc'];
    $val2 = $_SESSION['mailanc'];
    $val3 = $_SESSION['username'];
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
        $selectedoption4 = $_POST['vehicule'];
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

        $user = $_SESSION['username'];
        if ($ref && $nompiece && $prix && $garantie && $dureegarantie && $statutpiece && $longueur && $largeur && $epaisseur && $poids && $description && $designation) {
            $bdd->exec("INSERT INTO pieces (idPub, Reference, NomPiece, Prix, Garantie, DureeGarantie, StatutPiece, Longueur, Largeur, Epaisseur, Poids, Description, Designation, Username) VALUES ('','$ref','$nompiece',$prix,'$garantie','$dureegarantie','$statutpiece',$longueur,$largeur,$epaisseur,$poids,'$description','$designation','$user')");
            $idpubb = $bdd->query("SELECT max(idPub) AS idPub FROM pieces");
            $idpubb = $idpubb->fetch();
            $idP = $idpubb['idPub'];
            $bdd->exec("INSERT INTO composer (idVehicule, idPub) VALUES ($selectedoption4, $idP)");
            if (isset($_FILES['image']) AND ! empty($_FILES['image']['name'])) {
                $tailleMax = 2097152;
                $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
                if ($_FILES['image']['size'] <= $tailleMax) {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionsValides)) {

                        $chemin = "image/$idP." . $extensionUpload;
                        $res = move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
                        if ($res) {
                            $img = "$idP." . $extensionUpload;
                            $insert = $bdd->query("INSERT INTO photos (idPhoto, idPub, lien) VALUES ('',$idP,'$img')");
                        } else {
                            $msg = "ERREUR";
                        }
                    } else {
                        $msg = "Votre photo doit être de format jpg, jpeg, gif ou png";
                    }
                } else {
                    $msg = "Votre photo ne doit dépasser 2Mo";
                }
            }
            echo 'bien inserer';
        } else {
            echo 'veuillez saisir tout les champs';
        }
    }

    $pieces = $bdd->query("SELECT * FROM pieces WHERE Username='$val3'");
    ?>

    <html>
        <head> 
            <title>Mon profile</title>
            <link href="css/css/bootstrap.min.css" rel="stylesheet"> 

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="js/jquery10.js"></script>
            <script src="js/jquery11.js"></script> 
            <script src="jquery.min.js"></script>
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
                                $('#vehicule').html('<option value="">Sélectionner un moteur avant</option>');
                            }
                        });
                    } else {
                        $('#model').html('<option value="">Sélectionner une marque avant</option>');
                        $('#moteur').html('<option value="">Sélectionner un modèle avant</option>');
                        $('#vehicule').html('<option value="">Sélectionner un moteur avant</option>');
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
                                $('#vehicule').html('<option value="">Sélectionner un moteur avant</option>');
                            }
                        });
                    } else {
                        $('#moteur').html('<option value="">Sélectionner un modèle avant</option>');
                        $('#vehicule').html('<option value="">Sélectionner un moteur avant</option>');
                    }
                });
                $('#moteur').on('change', function () {
                    var moteurID = $(this).val();
                    if (moteurID) {
                        $.ajax({
                            type: 'POST',
                            url: 'ajaxData.php',
                            data: 'idMoteur=' + moteurID,
                            success: function (html) {
                                $('#vehicule').html(html);
                            }
                        });
                    } else {
                        $('#vehicule').html('<option value="">Sélectionner un moteur avant</option>');
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

                                    <li><a href="ProfileP.php">Mon profil</a></li>
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
                        <ul class="nav nav-divider " > 
                            <li class="nav-item"><a href="#item5" role="tab" data-toggle="tab">Mes publications</a></li>
                            <li class="nav-item"><a href="#item1" role="tab" data-toggle="tab">Ajouter une piéce</a></li>
                            <li class="nav-item"><a href="#item2" role="tab" data-toggle="tab">Modifier les informations</a></li>
                        </ul>
                        <a href="deconnecter.php"  class="btn btn-xs btn-danger" name="deco">Déconnexion</a>
                    </div>


                    <div class="tab-content">
                        <div role="tabpanel" class="row-fluid tab-pane active" id="item5">
                            <div class="col-md-10" style="margin-top: 50px">
    <?php
    if ($pieces->rowCount() > 0) {
        while ($a = $pieces->fetch()) {
            ?> 	
                                        <section class="col-xs-12 col-sm-6 col-md-12">
                                            <article class="search-result row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <a href="#" title="piece" class="thumbnail">
            <?php
            $idPub = $a['idPub'];
            $img = $bdd->query("SELECT lien FROM photos WHERE idPub=$idPub");
            $photo = $img->fetch();
            ?><img src="image/<?php echo $photo['lien']; ?>" /></a>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <ul class="meta-search">

                                                        <li><i class="glyphicon glyphicon-calendar"></i> <span><?php
                                                        $datetime = $a['DatePub'];
                                                        echo date("Y-m-d", strtotime($datetime));
                                                        ?></span></li>
                                                        <li><i class="glyphicon glyphicon-time"></i> <span><?php
                                            echo date("H:i:s", strtotime($datetime));
                                            ?></span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 excerpet">

                                                    <h3><a href="newEmptyPHP.php?id=<?php echo $a['idPub']; ?>"><?= $a['NomPiece'] ?></a></h3> <!-- href vers conculter-->
                                                    <p> Référence: <?= $a['Reference'] ?> </p>
                                                    <p> Disponsibilité: <?= $a['StatutPiece'] ?> </p>						
                                                    <span class="plus"><a href="newEmptyPHP.php?id=<?php echo $a['idPub']; ?>"><i class="glyphicon glyphicon-plus"></i></a></span> <!-- href vers conculter-->
                                                </div>
                                                <span class="clearfix borda"></span>
        <?php } ?>

    <?php } else { ?>
                                            <p style="font-size: 50px"> Vous avez aucune publication... </p>
    <?php } ?>
                                    </article>
                                </section>
                            </div>
                        </div>
                        <div role="tabpanel" class="row-fluid tab-pane" id="item1">
                            <div class="col-md-8">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
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
                                            <label class="control-label" for="Moteur">Choisissez un moteur </label>
                                            <div class="controls row-fluid">
                                                <select name="moteur" id="moteur">
                                                    <option value="">Sélectionner un modéle avant</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label class="control-label" for="Vehicule">Choisissez un vehicule </label>
                                            <div class="controls row-fluid">
                                                <select name="vehicule" id="vehicule">
                                                    <option value="">Sélectionner un moteur avant</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="ref" > Réference</label>
                                            <input  class="form-control" type="text" id="ref" name="ref">  
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="nompiece" > Nom piéce</label>
                                            <input  class="form-control" type="text" id="nompiece" name="nompiece">  
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="prix" > Prix</label>
                                            <input  class="form-control" type="text" id="prix" name="prix">  
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="garantie" > Garantie</label>
                                            <input  class="form-control" type="text" id="garantie" name="garantie">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="dureegarantie" > Durée garantie</label>
                                            <input  class="form-control" type="text" id="dureegarantie" name="dureegarantie">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="statutpiece" > Statut piéce</label>
                                            <input  class="form-control" type="text" id="statutpiece" name="statutpiece">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="longueur" > Longueur </label>
                                            <input  class="form-control" type="text" id="longueur" name="longueur">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="largeur" > Largeur </label>
                                            <input  class="form-control" type="text" id="largeur" name="largeur">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="epaisseur" > Epaisseur </label>
                                            <input  class="form-control" type="text" id="epaisseur" name="epaisseur">  
                                        </div> 
                                        <div class="form-group row-fluid">
                                            <label  for="poids" > Poids </label>
                                            <input  class="form-control" type="text" id="poids" name="poids">  
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="description" > Description </label>
                                            <textarea rows=4 class="form-control"  id="description" name="description"></textarea>
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="designation" > Designation </label>
                                            <textarea rows=4 class="form-control"  id="designation" name="designation"></textarea>
                                        </div>
                                        <div class="form-group row-fluid">
                                            <label  for="Image" > Image </label>
                                            <input  class="form-control" type="file" id="image" name="image"> 
    <?php if (isset($msg)) {
        echo $msg;
    } ?>
                                        </div>
                                        <button type="submit"  class="btn btn-primary offset1" name="ajout_piece">Valider</button>
                                    </form>
                                </div>
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

                    </div>
                </div>
            </div>
            <script src="js/js/jquery.js"></script>
            <script src="js/js/bootstrap.min.js"></script>
        </body>
    </html>
<?php } ?>