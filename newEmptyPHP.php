<link href="css/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="newcss.css" rel="stylesheet">
<script src="js/js/bootstrap.min.js"></script>
<script src="js/js/jquery111.js"></script>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        session_start();
        $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
        $use = $_SESSION['username'];

        if (isset($_GET['id'])) {

            $idd = $_GET['id'];
            $infos = $bdd->query("SELECT * FROM pieces WHERE idPub=$idd");
            $inf = $infos->fetch();

            $com = $bdd->query("SELECT idVehicule FROM composer WHERE idPub=$idd");
            $com = $com->fetch();
            $comv = $com['idVehicule'];

            $veh = $bdd->prepare("SELECT * FROM vehicule WHERE idVehicule=?");
            $veh->execute(array($comv));
            $veh = $veh->fetch();
            $vehm = $veh['idMoteur'];

            $mot = $bdd->prepare("SELECT * FROM moteur WHERE idMoteur=?");
            $mot->execute(array($vehm));
            $mot = $mot->fetch();
            $motm = $mot['idModel'];

            $mod = $bdd->prepare("SELECT * FROM model WHERE idModel=?");
            $mod->execute(array($motm));
            $mod = $mod->fetch();
            $modm = $mod['idMarque'];

            $mar = $bdd->prepare("SELECT * FROM marque WHERE idMarque=?");
            $mar->execute(array($modm));
            $mar = $mar->fetch();

            if (isset($_POST['cmt'])) {

                $cmt = $_POST['cmt'];
                $id = $_GET['id'];


                if ($cmt) {
                    $bdd->query("INSERT INTO commenter(Username, idPub, ContenuCom) VALUES ('$use',$id,'$cmt')");
                    echo 'bien inserer';
                } else {
                    echo 'veuillez saisir tout les champs';
                }
            }
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
            .widget .panel-body { padding:0px; }
            .widget .list-group { margin-bottom: 0; }
            .widget .panel-title { display:inline }
            .widget .label-info { float: right; }
            .widget li.list-group-item {border-radius: 0;border: 0;border-top: 1px solid #ddd;}
            .widget li.list-group-item:hover { background-color: rgba(86,61,124,.1); }
            .widget .mic-info { color: #666666;font-size: 11px; }
            .widget .action { margin-top:5px; }
            .widget .comment-text { font-size: 12px; }
            .widget .btn-block { border-top-left-radius:0px;border-top-right-radius:0px; }
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

                                <li> 
                                    <?php if ($_SESSION['type'] == 'Professionnel' || $_SESSION['type'] == 'Particulier') { ?>
                                        <a href="ProfileP.php">
                                        <?php } else if ($_SESSION['type'] == 'Administrateur') { ?>
                                            <a href="Profile.php">
                                            <?php } ?>
                                            Mon profil</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a class="glyphicon glyphicon-log-out" href="deconnecter.php"> Se déconnecter</a></li>
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
                                <?php
                                $idPub = $inf['idPub'];
                                $img = $bdd->query("SELECT lien FROM photos WHERE idPub=$idPub");
                                $photo = $img->fetch();
                                ?>
                                <div class="tab-pane active" id="pic-1">
                                    <img src="image/<?php echo $photo['lien']; ?>" /></a></div> 

                            </div>

                        </div>
                        <div class="details col-md-6">
                            <h3 class="product-title"><?php echo $inf['NomPiece']; ?></h3>
                            <span>publier par: <?php echo $inf['Username']; ?></span>
                            <?php
                            $usm = $inf['Username'];
                            $mail = $bdd->query("SELECT Email FROM utilisateur WHERE Username='$usm'");
                            $mail = $mail->fetch();
                            ?>
                            <span>contact: <?php echo $mail['Email']; ?></span>
                            <div class="survey-builder container">
                                <h3>Evaluer</h3>
                                <input type="hidden" class="rating" data-fractions="2"/>
                            </div>

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
                                <li> <p>Catégorie véhicule: <?php echo $veh['Categorie']; ?> <p> </li>
                                <li> <p>Année véhicule : <?php echo $veh['Annee']; ?> <p> </li>
                                <li> <p>Moteur : <?php echo $mot['NomMoteur']; ?> <p> </li>
                                <li> <p>Modéle : <?php echo $mod['NomModel']; ?> <p> </li>
                                <li> <p>Marque : <?php echo $mar['NomMarque']; ?> <p> </li>
                            </ul>
                            <h4 class="price">Prix: <span><?php echo $inf['Prix']; ?> DA</span></h4>
                            <u><a href="#" style="color: red; font-size: 20px">Signaler</a></u>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-lg-offset-2">
                    <div class="widget-area no-padding blank">
                        <div class="status-upload">
                            <form method="POST" action="">
                                <textarea name="cmt" placeholder="Commenter cette publication..." ></textarea>
                                <button type="submit" class="btn btn-success green"><i class="glyphicon glyphicon-comment"></i> Commenter</button>
                            </form>
                        </div><!-- Status Upload  -->
                    </div><!-- Widget Area -->
                </div>
            </div>

            <div class="row">
                <div class="panel panel-default widget col-md-8 col-lg-offset-2">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-comment"></span>
                        <h3 class="panel-title">
                            Commentaire récent</h3>
                        <span class="label label-info">
                            <?php
                            $nbr = $bdd->query("SELECT COUNT(*) FROM commenter WHERE idPub=$idd")->fetchColumn();
                            echo $nbr;
                            ?></span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php
                            $com = $bdd->query("SELECT * FROM commenter WHERE idPub=$idd ORDER BY Date DESC");
                            if ($com->rowCount() > 0) {
                                while ($comm = $com->fetch()) {
                                    ?>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-xs-10 col-md-11">
                                                <div>
                                                    <div class="mic-info">
                                                        Par: <?php echo $comm['Username']; ?> Le <?php echo $comm['Date']; ?>
                                                    </div>
                                                </div>
                                                <div class="comment-text"style="font-size: 20px">
        <?php echo $comm['ContenuCom']; ?>
                                                </div>
                                                <div class="action">
                                                    <button type="button" name="edit" class="btn btn-primary btn-xs" title="Edit">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs" title="Delete">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/js/jquery113.js"></script>
        <script src="js/js/jqueryrating.js"></script>
        <script>
            $(function () {
                $('input.check').on('change', function () {
                    alert('Rating: ' + $(this).val());
                });
                $('#programmatically-set').click(function () {
                    $('#programmatically-rating').rating('rate', $('#programmatically-value').val());
                });
                $('#programmatically-get').click(function () {
                    alert($('#programmatically-rating').rating('rate'));
                });
                $('#programmatically-reset').click(function () {
                    $('#programmatically-rating').rating('rate', '');
                });
                $('.rating-tooltip').rating({
                    extendSymbol: function (rate) {
                        $(this).tooltip({
                            container: 'body',
                            placement: 'bottom',
                            title: 'Rate ' + rate
                        });
                    }
                });
                $('.rating-tooltip-manual').rating({
                    extendSymbol: function () {
                        var title;
                        $(this).tooltip({
                            container: 'body',
                            placement: 'bottom',
                            trigger: 'manual',
                            title: function () {
                                return title;
                            }
                        });
                        $(this).on('rating.rateenter', function (e, rate) {
                            title = rate;
                            $(this).tooltip('show');
                        })
                                .on('rating.rateleave', function () {
                                    $(this).tooltip('hide');
                                });
                    }
                });
                $('.rating').each(function () {
                    $('<span class="label label-default"></span>')
                            .text($(this).val() || ' ')
                            .insertAfter(this);
                });
                $('.rating').on('change', function () {
                    $(this).next('.label').text($(this).val());
                });
            });
        </script>
    </body>
</html>
