<link href="css/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="newcss.css" rel="stylesheet">
<script src="js/js/bootstrap.min.js"></script>
<script src="js/js/jquery111.js"></script>
<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        if (isset($_GET['id'])) {
            $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
            $idd = $_GET['id'];
            $infos = $bdd->query("SELECT * FROM pieces WHERE idPub=$idd");
            $inf = $infos->fetch();
        }
        ?>
        <title><?php echo $inf['NomPiece']; ?></title>

        <link href="css/css/bootstrap.min.css" rel="stylesheet">
        <link href="Consulter.css" rel="stylesheet">
        <script src="Consulter.js"></script>
        <script src="js/jquery10.js"></script>
        <script src="js/js/bootstrap.min.js"></script>
        <style>
            ul.dropdown-lr {
                width: 300px;
            }
        </style>
    </head>
    
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
        <div class="container" style="margin-top:50px">
            <div class="card">
                <div class="container-fliud">
                    <div class="wrapper row">
                        <div class="preview col-md-6">
                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-1">
                                    <?php
                                    $idPub = $inf['idPub'];
                                    $img = $bdd->query("SELECT lien FROM photos WHERE idPub=$idPub");
                                    $photo = $img->fetch();
                                    ?><img src="image/<?php echo $photo['lien']; ?>" /></a></div>  <!-- if il existe plus d'une photo pour cette publication on les affiche ci-dessous -->

                            </div>

                        </div>
                        <div class="details col-md-6">
                            <h3 class="product-title"><?php echo $inf['NomPiece']; ?></h3>
                            <span>publier par: <?php echo $inf['Username']; ?></span>
                            <h3>Description de la pièce</h3>
                            <ul class="product-description">
                                <li> <p>Référence de la pièce : <?php echo $inf['Reference']; ?> <p> </li>
                                <li> <p>Garantie de la pièce : <?php echo $inf['Garantie']; ?> <p> </li>
                                <li> <p>Durée de garantie : <?php echo $inf['DureeGarantie']; ?> <p> </li>
                                <li> <p>Statut de la pièce : <?php echo $inf['StatutPiece']; ?> <p> </li>
                                <li> <p>Longueur de la pièce : <?php echo $inf['Longueur']; ?> <p> </li>
                                <li> <p>Largeur de la pièce : <?php echo $inf['Largeur']; ?> <p> </li>
                                <li> <p>Epaisseur de la pièce : <?php echo $inf['Epaisseur']; ?> <p> </li>
                                <li> <p>Poids de la pièce : <?php echo $inf['Poids']; ?> <p> </li>
                            </ul>
                            <h4 class="price">Prix: <span><?php echo $inf['Prix']; ?> DA</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
