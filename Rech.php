<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recherche</title>

        <link href="css/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
        if (isset($_GET['search']) && (!empty($_GET['search']))) {
            $search = $_GET['search'];
            $nbr = $bdd->query("SELECT COUNT(*) FROM pieces WHERE NomPiece LIKE '%" . $search . "%'")->fetchColumn();
            $pieces = $bdd->query("SELECT * FROM pieces WHERE NomPiece LIKE '%" . $search . "%'");
        }
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
            <hgroup class="mb20">
                <h1>Résultat de la recherche</h1>
                <h2 class="lead"><strong class="text-danger"> <?php echo $nbr; ?></strong> Résultat trouver pour <strong class="text-danger"><?= $search ?></strong></h2>
            </hgroup>
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
                                    <li> <span> Publier par: <br> <i class="glyphicon glyphicon-user"></i>
                                            <span><?php echo $a['Username']; ?> </span>
                                        </span></li>
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
                        Aucun résultat... 
<?php } ?>
                </article>
            </section>
        </div>
        <script src="js/js/jquery111.js"></script>
        <script src="js/js/bootstrap.min.js"></script>
    </body>
</html>