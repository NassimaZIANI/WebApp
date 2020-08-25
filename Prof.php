
<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
if (isset($_GET['id'])) {

    $userp = $_GET['id'];

    $pro = $bdd->query("SELECT * FROM utilisateur WHERE Username='$userp'");
    $pro = $pro->fetch();
    $pieces = $bdd->query("SELECT * FROM pieces WHERE Username='$userp'");
}
?>

<html>
    <head> 
        <title> profile de <?php echo $userp; ?></title>
        <link href="css/css/bootstrap.min.css" rel="stylesheet"> 

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery10.js"></script>
        <script src="js/jquery11.js"></script> 
        <script src="jquery.min.js"></script>
    </head>
    <style>

        .glyphicon {  margin-bottom: 10px;margin-right: 10px;}

    </style>
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
        <div class="container-fluid" style="margin-top:50px">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6" style="margin-top: 50px">
                    <div class="well well-sm col-lg-5">
                        <div class="row">
                            <div class="col-sm-6 col-md-8">
                                <h4> <?php echo $pro['NomUser'] . " " . $pro['Prenom']; ?></h4>
                                <p>
                                    <i class="glyphicon glyphicon-envelope"></i><?php echo $pro['Email'] ?>
                                    <br />
                                    <i class="glyphicon glyphicon-map-marker"></i><?php echo $pro['Adresse'] ?>
                                    <br />
                                    <i class="glyphicon glyphicon-home"></i><?php echo $pro['NomEntreprise'] ?>
                                    <br />
                                    <i class="glyphicon glyphicon-globe"></i><a href="<?php echo $pro['SiteWeb'] ?>"><?php echo $pro['SiteWeb'] ?></a>
                                    <br />
                                    <i class="glyphicon glyphicon-gift"></i><?php echo $pro['DateNais'] ?></p>
                                <i><button type="submit"  class="btn btn-primary offset1">Contacter</button></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-md-offset-3" style="margin-top: 50px">


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
        </div>
    </div>
    <script src="js/js/jquery.js"></script>
    <script src="js/js/bootstrap.min.js"></script>
    <script src="js/js/jquery111.js"></script>
</body>
</html>