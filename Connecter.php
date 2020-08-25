<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page d'accueil</title>

        <link href="css/css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery10.js"></script>
        <script src="js/jquery11.js"></script> 
        <script src="jquery.min.js"></script>

        <style>
            ul.dropdown-lr {
                width: 300px;
            }
            .container{
                margin-top: 50px; 
                margin-bottom: 50px;
                margin-left: 50px;
            }
            .control-label{
                font-size: 30px;
                color: black;
            }
            .form-actions{
                height: 330px;
                background: transparent;
                border-radius: 3px;
                margin-top: 150px;
                padding: 15px;
                color: black;
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
        });
    </script>

    <body>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
        $pub = $bdd->query("SELECT * FROM pieces ORDER BY DatePub DESC LIMIT 6");
        ?>
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
                                            session_start();
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
        <div class="container-fluid" style="margin-top: 50px">
            <div class="form-actions row-fluid">
                <form  class="form-horizontal " method="POST" action="" style="text-align: center"> 
                    <div class="span6 offset3">
                        <div class="control-group row-fluid" >
                            <label class="control-label" for="Marque">Choisissez une marque</label>
                            <div class="controls row-fluid">

                                <?php
                                //Include database configuration file
                                include('dbConfig.php');

                                //Get all country data
                                $query = $db->query("SELECT idMarque, NomMarque FROM marque ORDER BY NomMarque ASC");

                                //Count total number of rows
                                $rowCount = $query->num_rows;
                                ?>
                                <select name="marque" id="marque" style="text-align: center; font-size: 15px; width: 400px; height: 38px;  border-radius: 12px 0px 0px 12px " >
                                    <option value="">Sélectionner une marque</option>
                                    <?php
                                    if ($rowCount > 0) {
                                        while ($row = $query->fetch_assoc()) {
                                            echo '<option value="' . $row['idMarque'] . '">' . $row['NomMarque'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">marque not available</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label class="control-label" for="Model">Choisissez un modèle </label>
                            <div class="controls row-fluid">
                                <select name="model" id="model" style="text-align: center; font-size: 15px; width: 400px; height: 38px ;border-radius: 12px 0px 0px 12px ">
                                    <option value="">Sélectionner une marque avant</option>
                                </select>                        </div>
                        </div>
                        <div class="control-group row-fluid">
                            <label class="control-label" for="Moteur">Choisissez un moteur </label>
                            <div class="controls row-fluid">
                                <select name="moteur" id="moteur" style="text-align: center; font-size: 15px; width: 400px; height: 38px;border-radius: 12px 0px 0px 12px  ">
                                    <option value="">Sélectionner un modéle avant</option>
                                </select>
                            </div>
                        </div>
                        <br><br>

                        <button type="submit"  class="btn btn-default offset3" name="insc_part" style="background-color: white; opacity: 1.5"> Recherche Avancée   <span class="glyphicon glyphicon-search"></span></button>

                    </div>
                </form>
            </div>
            <div class="container marketing">

                <!-- Three columns of text below the carousel -->
                <div class="row">
                    <?php
                    if ($pub->rowCount() > 0) {
                        while ($p = $pub->fetch()) {
                            ?> 	
                            <div class="col-md-4 text-center">
                                <?php
                                $idPub = $p['idPub'];
                                $img = $bdd->query("SELECT lien FROM photos WHERE idPub=$idPub");
                                $photo = $img->fetch();
                                ?>
                                <img style="width: 200px" src="image/<?php echo $photo['lien']; ?>">
                                <h2><?php echo $p['NomPiece']; ?></h2>
                                <p>Référence: <?php echo $p['Reference']; ?></p>
                                <p>Disponibilité: <?php echo $p['StatutPiece']; ?></p>
                                <p><a class="btn btn-default" href="Cons.php?id=<?php echo $p['idPub']; ?>">Voir plus de détail »</a></p>
                            </div>
                        <?php }
                    }
                    ?>
                </div><!-- /.row -->

            </div>
        </div>
        <script src="js/js/jquery.js"></script>
        <script src="js/js/bootstrap.min.js"></script>
    </body>
</html>