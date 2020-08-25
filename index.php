<!DOCTYPE html>
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
                border-radius: 3px;
                padding: 15px;
            }

            .featurette-divider {
                margin: 80px 0; /* Space out the Bootstrap <hr> more */
            }
            .featurette {
                padding-top: 120px; /* Vertically center images part 1: add padding above and below text. */
                overflow: hidden; /* Vertically center images part 2: clear their floats. */
            }
            .featurette-image {
                margin-top: -120px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
            }

            /* Give some space on the sides of the floated elements so text doesn't run right into it. */
            .featurette-image.pull-left {
                margin-right: 40px;
            }
            .featurette-image.pull-right {
                margin-left: 40px;
            }

            /* Thin out the marketing headings */
            .featurette-heading {
                font-size: 50px;
                font-weight: 300;
                line-height: 1;
                letter-spacing: -1px;
            }
            @media (min-width: 768px) {

                /* Remve the edge padding needed for mobile */
                .marketing {
                    padding-left: 0;
                    padding-right: 0;
                }


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
                        <li class="active"><a href="./"> Accueil </a></li>
                    </ul>
                    <form action="Recherche.php" method="GET" class="navbar-form navbar-left" role="search">
                        <div class="input-group">
                            <input type="search" class="form-control" name="search" placeholder="Chercher une piéce">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <a class="glyphicon glyphicon-search"></a>
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="inscrire.php">S'inscrire</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compte <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
                                <div class="col-lg-12">
                                    <div class="text-center"><h3><b>Log In</b></h3></div>
                                    <form id="ajax-login-form" action="SeConnecter.php" method="post" role="form" autocomplete="off">
                                        <div class="form-group">
                                            <label class="control-label" for="mail">Email</label>
                                            <div class="inputGroupContainer">
                                                <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                    <input type="text" name="mail" id="email" tabindex="1" class="form-control" placeholder="email" value="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="mdp">Mot de passe</label>
                                            <div class="inputGroupContainer">
                                                <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input type="password" name="mdp" id="mdp" tabindex="2" class="form-control" placeholder="Password" autocomplete="off">
                                                </div>
                                            </div>   
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-7 pull-right">
                                                    <button type="submit" class="form-control btn-success"> <span class="glyphicon glyphicon-log-in"> Se connecter</span></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="mdp.php" tabindex="5" class="forgot-password">Mot de passe oublié?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="a465a2791ae0bae853cf4bf485dbe1b6">
                                    </form>
                                </div>
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
} ?>
                </div><!-- /.row -->

            </div>
        </div>
        <script src="js/js/jquery.js"></script>
        <script src="js/js/bootstrap.min.js"></script>
        <script>
              history.pushState(null, null, document.title);
              window.addEventListener('popstate', function () {
                  history.pushState(null, null, document.title);
              });
        </script>
    </body>
</html>
