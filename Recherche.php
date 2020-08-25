<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recherche</title>

        <link href="css/css/bootstrap.min.css" rel="stylesheet">
        <style>
            ul.dropdown-lr {
                width: 300px;
            }
        </style>
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
            <hgroup class="mb20">
                <h1>Résultat de la recherche</h1>
                <h2 class="lead"><strong class="text-danger"> <?php echo $nbr; ?></strong> Résultat trouver pour <strong class="text-danger"><?= $search ?></strong></h2>
            </hgroup>
            <?php
            if ($pieces->rowCount() > 0) {
                while ($a = $pieces->fetch()) {
                    $_SESSION['n'] = $a['NomPiece'];
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
                                    <li> <span> Publier par: <br> <i class="glyphicon glyphicon-user"></i> <?php
                                    echo $a['Username'];
                                    ?></span></li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 excerpet">

                                <h3><a href="Cons.php?id=<?php echo $a['idPub']; ?>"><?= $a['NomPiece'] ?></a></h3> <!-- href vers conculter-->
                                <p> Référence: <?= $a['Reference'] ?> </p>
                                <p> Disponsibilité: <?= $a['StatutPiece'] ?> </p>						
                                <span class="plus"><a href="Cons.php?id=<?php echo $a['idPub']; ?>"><i class="glyphicon glyphicon-plus"></i></a></span> <!-- href vers conculter-->
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