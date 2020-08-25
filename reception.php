<?php
session_start();

if (isset($_SESSION['username']) And ! empty($_SESSION['username'])) {
    $us = $_SESSION['username'];
    $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
    // c'est le username de l'emetteur de message qui est dans la  page profile 

    if (isset($_POST['envoie'])) {
        if (isset($_POST['des'], $_POST['message']) and ! empty($_POST['des']) and ! empty($_POST['message'])) { // isset pour l'existance des champs et empty si pour remplire les champs
            $emE = $_SESSION['mailanc'];  // l'email de l'emetteur de message
            if ($_POST['des'] == $emE) {
                $erreur = 'vouz ne pouvez pas envoyer un message à cet email ';
            } else {
                $destinaitaire = htmlspecialchars($_POST['des']); // securisé
                $message = htmlspecialchars($_POST['message']);
                $objet = htmlspecialchars($_POST['objetm']);
                $id_des = $bdd->prepare('SELECT MDP,Username FROM utilisateur WHERE Email=?');   //de la table utilisateur pour savoir le username de destinaitaire
                $id_des->execute(array($_POST['des']));
                $id_exs = $id_des->rowCount();
                if ($id_exs == 1) {
                    $id_des = $id_des->fetch();
                    $id_des1 = $id_des['Username'];
                    $id_des2 = $id_des['MDP'];
                    /* var_dump($id_des1); */// juste pour assurer la selection 
                    //echo $us."  a envoyée un message a  "  .$id_des1;
                    $ins = $bdd->prepare("INSERT INTO `message`(`idMsg`, `ContenuMsg`, `Objet`, `Etat`, `idEmetteur`) VALUES (?,?,?,?,?)");
                    $ins->execute(array('', $message, $objet, 'non lu', $us));

                    $qu = $bdd->prepare('SELECT max(idMsg) as idMsg FROM message WHERE idEmetteur=?');
                    $qu->execute(array($us));
                    $qu = $qu->fetch();
                    $id = $qu['idMsg'];

                    // echo '  et id message est  '.$id;

                    $ins2 = $bdd->prepare("INSERT INTO `recevoir`(`idRecepteur`, `idMsg`) VALUES(?,?) ");
                    $ins2->execute(array($id_des1, $id));
                    $erreur1 = "votre msg a bien était envoyer";
                } else {
                    $erreur = "le destinataire n'existe pas";
                }
            }
        } else {
            $erreur = "vous n'avez pas saisis tout les champs";
        }
    }
    $dess = $bdd->query('SELECT Email FROM utilisateur ORDER BY Email');
//requete
//select * from ma_table where rownum >= all 
//( 
//select * from ma_table order by rownum asc 
//);
    $que = $bdd->prepare('SELECT *  FROM message WHERE idEmetteur=?');
    $que->execute(array($us));
    $msg_n = $que->rowCount();
    ?>
    <?php
// il reste la suppression du message
    $bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
    $msg = $bdd->prepare('SELECT idMsg FROM recevoir WHERE idRecepteur=?');
    $msg->execute(array($_SESSION['username'])); // on l'utilise qu'on est dans un profile*/
    $msg = $msg->fetch();
    $msg1 = $bdd->prepare('SELECT * FROM message WHERE idMsg IN ( SELECT idMsg FROM recevoir WHERE idRecepteur=? ) ORDER BY idMsg Desc');
    $msg1->execute(array($_SESSION['username'])); //on a selectionner les message qui a recu l'utilisateur
    $msg_nbr = $msg1->rowCount(); // compte le nombre de renger
    ?>
    <html>
        <head>
            <title>boite de reception</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="css/css/bootstrap.min.css" rel="stylesheet">  
            <style>        
            </style>
        </head>
        <body style="background-color: #eeebeb">
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


                        <form action="Rech.php" method="GET" class="navbar-form navbar-left" role="search">
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

            <div class="container col-sm-8 col-sm-offset-2" style="margin-top: 60px">
                <div class="panel panel-default " style="background-color: grey; opacity: 0.7">
                    <div class="panel panel-heading">  <h1 style="text-align: center; color: black">Messagerie
                            <span class="glyphicon glyphicon-envelope pull-right">  </span>
                        </h1></div>
                    <div class="panel-body">

                        <div class="col-md-3">
                            <ul class="nav navbar-default"> 
                                <li class="nav-item" ><a  href="#nouveau" role="tab" data-toggle="tab" style="color: black">nouveau message </a></li>
                                <li class="nav-item"><a href="#envoye" role="tab" data-toggle="tab" style="color: black">les message envoyés</a></li>
                                <li class="nav-item"><a href="#boite" id="rec" role="tab" data-toggle="tab" style="color: black">boite de reception</a></li>
                            </ul></div>
                        <div class="tab-content col-lg-8">
                            <div role="tabpanel" class="row-fluid tab-pane active" id="nouveau">
                                <div class="container-fluid">
                                    <div class="col-lg-12">
                                        <div class="well">
                                            <form class="form-horizontal" method="POST">
                                              <!--  <select name="des">
    <?php while ($d = $dess->fetch()) { ?>     
                                                        <option> <?= $d['Email'] ?></option> 
                                                <?php } ?>
                                                </select>  -->
                                                <div class="form-group row-fluid">
                                                    <label  for="email" > E-mail</label>
                                                    <input  class="form-control" type="text" id="email" name="des">  
                                                </div> 
                                                <div class="form-group row-fluid">
                                                    <label  for="objet" > Objet</label>
                                                    <input  class="form-control" type="text" id="objet" name="objetm">  
                                                </div> 
                                                <div class="form-group row-fluid">
                                                    <label class="control-label " for="adresse" >Contenu message</label>

                                                    <textarea rows=4 class="form-control"  id="adresse" name="message"></textarea><br>
                                                    <button type="submit"  class="btn btn-default" name="envoie"> Envoyer</button><br>
                                                    <p style=" color:#ff3333; text-align: center ">  <?php if (isset($erreur)) {
                                                    echo $erreur;
                                                } else {
                                                    if (isset($erreur1)) { ?></p> <p style="color: green;text-align: center"> <?php echo $erreur1;
                                                    }
                                                } ?></p>
                                                </div>


                                            </form></div></div></div>  
                            </div> 
                            <div role="tabpanel" class="row-fluid tab-pane" id="envoye">

                                <div class="panel panel-default widget">
                                    <div class="panel-heading">
                                        <span class="glyphicon glyphicon-envelope pull-right"></span>
                                        <h3 class="panel-title">
                                            Les message envoyer</h3>

                                    </div>
                                    <div class="panel-body row-fluid">
                                        <ul class="list-group">
                                            <?php
                                            if ($msg_n == 0) {
                                                echo "vous n'avez envoyé aucun message";
                                            } else
                                                while ($me = $que->fetch()) {
                                                    $b = $bdd->prepare('SELECT idRecepteur FROM recevoir WHERE idMsg=?');
                                                    $b->execute(array($me['idMsg'])); // on l'utilise qu'on est dans un profile*/
                                                    $b = $b->fetch();
                                                    $id_des = $b['idRecepteur'];
                                                    ?>  
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-xs-10 col-md-12">
                                                                <div>
                                                                    <div class="mic-info">
                                                                        Message envoyé à: <span style="color: #ff6600"> <?php echo $id_des; ?></span>   Le  <?php echo $me['Date']; ?><span class="pull-right" style="font-size: 14px"> <?php echo $me['Etat'] . " "; ?> <?php if ($me['Etat'] == 'lu') { ?> <span class="glyphicon glyphicon-ok" ></span> <?php } ?></span>
                                                                    </div>
                                                                </div>


                                                                <blockquote class="pull-left">
            <?php $con = $me['ContenuMsg'];
            echo "$con"; ?>
                                                                </blockquote>


                                                                <div class="action pull-right">
                                                                    <form method="POST" action="#">
                                                                        <button type="submit" class="btn btn-danger btn-xs" name="<?php $p = "m" . $me['idMsg'];
            echo $p; ?>" title="Delete"  style="background-color: #ff6600">
                                                                            <span class="glyphicon glyphicon-trash"></span>
                                                                            <?php
                                                                            if (isset($_POST[$p])) {
                                                                                $pp = $me['idMsg'];
                                                                                $bdd->exec("DELETE FROM `recevoir` WHERE idMsg=$pp");
                                                                                $bdd->exec("DELETE FROM `message` WHERE idMsg=$pp");
                                                                            }
                                                                            ?>
                                                                        </button></form>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </li>
        <?php } ?>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                            <div role="tabpanel" class="row-fluid tab-pane" id="boite">

                                <div class="panel panel-default widget">
                                    <div class="panel-heading">
                                        <span class="glyphicon glyphicon-envelope pull-right"></span>
                                        <h3 class="panel-title">
                                            Les messages reçus</h3>

                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            <?php
                                            $lu = $bdd->prepare("UPDATE `message` SET `Etat`='lu' WHERE idMsg IN ( SELECT idMsg FROM recevoir WHERE idRecepteur=?)");
                                            $lu->execute(array($_SESSION['username']));
                                            if ($msg_nbr == 0) {
                                                echo "vous n'avez aucun message";
                                            } else
                                                while ($m = $msg1->fetch()) {
                                                    $b = $bdd->prepare('SELECT idEmetteur,Etat FROM message WHERE idMsg=?');
                                                    $b->execute(array($m['idMsg'])); // on l'utilise qu'on est dans un profile*/
                                                    $b = $b->fetch();
                                                    $id_exp = $b['idEmetteur'];
                                                    ?>   
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-xs-10 col-md-12">
                                                                <div>
                                                                    <div class="mic-info">
                                                                        Envoyé par: <span  style="color: #ff6600">  <?= $id_exp . "" ?></span>  <span class="col-lg-offset-1 pull-right"> Le  <?php echo $m['Date']; ?></span>
                                                                    </div>
                                                                </div>

                                                                <blockquote class="pull-left">
            <?php echo $m['ContenuMsg']; ?></p>
                                                                </blockquote> 

                                                                <div class="action pull-right">
                                                                    <form method="POST" action="#">
                                                                        <button type="submit" class="btn btn-danger btn-xs" name="<?php $i = "id" . $m['idMsg'];
            echo $i; ?>" title="Delete"  style="background-color: #ff6600">
                                                                            <span class="glyphicon glyphicon-trash"></span>

                                                                        </button></form>
            <?php
            if (isset($_POST[$i])) {
                $p = $m['idMsg'];
                $bdd->exec("DELETE FROM `recevoir` WHERE idMsg=$p");
                $bdd->exec("DELETE FROM `message` WHERE idMsg=$p");
            }
            ?> 
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </li>
        <?php } ?>
                                        </ul>
                                    </div>

                                </div>







                            </div>





                        </div></div></div>
            </div>


            <script src="js/jquery-latest.js"></script>
            <script src="js/js/bootstrap.min.js"></script> 

        </body>
    </html>
<?php } ?>