<?php
/* il reste 
  / la condition pour unique usernams, email
  / la condition pour les caractère spéciaux pour nom et prenom
  / condition pour site
 */
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
//particulier
if (isset($_POST['inscpart'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $daten = $_POST['daten'];
    $numtel = $_POST['numtel'];
    $adresse = $_POST['adresse'];

    $veri = $bdd->prepare('SELECT MDP,Username,Email FROM utilisateur Where MDP=? or Username=? or Email=?');
    $veri->execute(array($mdp, $username, $email));
    $ve = $veri->rowCount();

    if ($ve == 0) {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT); // pour crypter le mot de passe
        $bdd->exec("INSERT INTO utilisateur(Username, TypeUser, NomUser, Prenom, DateNais, Adresse, NumTel, Email, MDP, StatutUser) VALUES ('$username', 'Particulier' ,'$nom','$prenom','$daten','$adresse','$numtel','$email','$mdp', 'Active')");
        $typeuser = "Particulier";
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['nom1'] = $_POST['nom'];
        $_SESSION['prenom1'] = $_POST['prenom'];
        $_SESSION['type'] = $typeuser;
        $_SESSION['mdpanc'] = $_POST['mdp'];
        $_SESSION['mailanc'] = $_POST['email'];
        $_SESSION['num'] = $_POST['numtel'];
        header("Location:Connecter.php");
    } else {
        $veri = $veri->fetch();
        $userv = $veri['Username'];
        $mdpv = $veri['MDP'];
        $emailv = $veri['Email'];
        if ($userv == $username) {
            $valeur = "Username existe déja, veuillez saisir un autre username svp";
        } else {
            if ($emailv == $email) {
                $valeur = "Email existe déja, veuillez saisir un autre email svp";
            }
        }
    }
} else {
// professionnel
    if (isset($_POST['inscprof'])) {
        $nom = $_POST['nomp'];
        $prenom = $_POST['prenomp'];
        $username = $_POST['usernamep'];
        $daten = $_POST['datenp'];
        $adresse = $_POST['adressep'];
        $numtel = $_POST['numtelp'];
        $email = $_POST['emailp'];
        $mdp = $_POST['mdpp'];
        $societe = $_POST['societe'];
        $site = $_POST['site'];
        $veri = $bdd->prepare('SELECT MDP,Username,Email FROM utilisateur Where MDP=? or Username=? or Email=?');
        $veri->execute(array($mdp, $username, $email));
        $ve = $veri->rowCount();

        if ($ve == 0) {
            $mdp = password_hash($mdp, PASSWORD_DEFAULT); // pour crypter le mot de passe
            $bdd->exec("INSERT INTO utilisateur(Username, TypeUser, NomUser, Prenom, DateNais, Adresse, NumTel, Email, MDP, StatutUser,NomEntreprise, SiteWeb ) VALUES ('$username', 'Professionnel' ,'$nom','$prenom','$daten','$adresse','$numtel','$email','$mdp','Active','$societe','$site')");
            $typeuser = "Professionnel";
            $_SESSION['username'] = $_POST['usernamep'];
            $_SESSION['nom1'] = $_POST['nomp'];
            $_SESSION['prenom1'] = $_POST['prenomp'];
            $_SESSION['type'] = $typeuser;
            $_SESSION['mdpanc'] = $_POST['mdpp'];
            $_SESSION['mailanc'] = $_POST['emailp'];
            $_SESSION['num'] = $_POST['numtelp'];
            $_SESSION['soc'] = $_POST['societe'];  //
            $_SESSION['site'] = $_POST['site'];  //
            $_SESSION['adresse'] = $_POST['adresse']; //
            header("Location:Connecter.php");
        } else {
            $veri = $veri->fetch();
            $userv = $veri['Username'];

            $emailv = $veri['Email'];
            if ($userv == $username) {
                echo "Username existe déja, veuillez saisir un autre username svp";
            } else {
                if ($emailv == $email) {
                    $valeur2 = "Email existe déja, veuillez saisir un autre email svp";
                }
            }
        }
    }
}
?>

<html ><head><title>formulaire d'inscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .input-group-addon{
                background-color: #333333 ;
                border-color:  #444;
                color: white;
            }

            .panel-body{
                padding-top: 0px;
                font-size: 17px;
            }
            .leg{
                padding-top: 10px;
            }
            .hh{
                padding: 6px;
                height: 90px;
                background-color: #444;
            }
            .btns{background-color: #444;
                  height: 38px;
                  width: 120px;
                  font-size: 18px;
                  opacity: 0.70px;
                  color: whitesmoke;
            }
            #aa{
                color:  #444;
            }
            ul.dropdown-lr {
                width: 300px;
            }


        </style>      

    </head><body style="background-color:  #EEEEEE">
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
                        <li><a href="inscrire.html">S'inscrire</a></li>
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
                                                    <input type="text" name="mail" id="email" tabindex="1" class="form-control" placeholder="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="mdp">Mot de passe</label>
                                            <div class="inputGroupContainer">
                                                <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input type="password" name="mdp" id="mdp1" tabindex="2" class="form-control" placeholder="Password" autocomplete="off">
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
                                                        <a href="#" tabindex="5" class="forgot-password">Mot de passe oublié?</a>
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
            <div class="row-fluid">
                <br>
                <div class="container-fluid col-lg-10 col-lg-offset-1 pp"> 
                    <div class="panel panel-default row-fluid">
                        <div class="panel  hh">  <h1 style="text-align: center; color: white"> Inscription <small style="font-size: 19px; color: whitesmoke">  Je suis un nouvel utilisateur</small>
                                <span class="glyphicon glyphicon-edit pull-right">  </span>
                            </h1></div>
                        <div class="panel-body">
                            <div class="col-lg-12 ">

                                <p style="color: red; size: 13px; text-align: center"  ><?php
                                    if (isset($valeur)) {
                                        echo $valeur;
                                    } else {
                                        if (isset($valeur2)) {
                                            echo $valeur2;
                                        }
                                    }
                                    ?></p>
                                <ul class="nav nav-tabs " > 
                                    <li class="nav-item "><a id="aa" href="#part" role="tab" data-toggle="tab"> Particulier </a></li>
                                    <li class="nav-item"><a id="aa" href="#prof" role="tab" data-toggle="tab"> Professionnel </a></li>
                                </ul>
                                <div class="tab-content">

                                    <div role="tabpanel" class="row-fluid tab-pane fade in active" id="part">

                                        <form class="form-horizontal" id="reg_formpar" action="" method="POST">

                                            <fieldset>
                                                <legend class="leg" style="text-align: center">  Information personnel </legend>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input  name="nom" placeholder="saisir votre Nom" class="form-control"  type="text"><!--pattern="[a-zA-Z]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input name="prenom" placeholder="Saisir votre Prenom" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input name="username" placeholder="Saisir votre Username" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                            <input name="daten" class="form-control" type="date" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                            <input name="numtel" class="form-control" type="tel" pattern="0(5|6|7)[0-9]{8}" placeholder="saisir votre numéro de téléphone">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <textarea class="form-control" name="adresse" placeholder="Adresse "></textarea>

                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>

                                            <fieldset>
                                                <legend style="text-align: center"> information du compte </legend> 
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                            <input name="email" placeholder="email@exemple.com" class="form-control"  type="email">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group has-feedback">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                            <input class="form-control" id="mdp" type="password" placeholder="Saisissez votre mot de passe" name="mdp" />
                                                            <span class="glyphicon form-control-feedback"></span>
                                                            <span class="help-block with-errors"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group has-feedback">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                            <input class="form-control {$borderColor}" type="password" placeholder="confirmez le mot de passe" name="c-mdp" />
                                                            <span class="glyphicon form-control-feedback"></span>
                                                            <span class="help-block with-errors"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"></label>
                                                    <div class="col-md-offset-5">
                                                        <button type="submit" id="submit-button" class="form-control btn btns " name='inscpart' > Valider  <span class="glyphicon glyphicon-send"></span></button>
                                                    </div>
                                                </div>

                                            </fieldset>   
                                        </form>
                                    </div>




                                    <div role="tabpanel" class="row-fluid tab-pane fade" id="prof">

                                        <form class="form-horizontal" action="#" method="post"  id="reg_formprof">  

                                            <fieldset>
                                                <legend class="leg" style="text-align: center"> Information personnel </legend>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3 inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input  name="nomp" placeholder="saisir votre nom" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input name="prenomp" placeholder="Saisir votre prenom" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input name="usernamep" placeholder="Saisir votre username" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                            <input name="datenp" class="form-control" type="date" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                                            <input name="numtelp" class="form-control" type="tel" pattern="0(5|6|7)[0-9]{8}" placeholder="saisir votre numéro de téléphone"">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <textarea class="form-control" name="adressep" placeholder="Adresse "></textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                            <input  name="societe" placeholder="saisir le nom de la société" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                                            <input  name="site" placeholder="le site de la société" class="form-control"  type="text">
                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>

                                            <fieldset>
                                                <legend style="text-align: center" > information du compte </legend> 
                                                <div class="form-group">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                            <input name="emailp" placeholder="email@exemple.com" class="form-control"  type="email">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group has-feedback">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                            <input class="form-control" id="mdpp" type="password" placeholder="Saisissez votre mot de passe" name="mdpp" />
                                                            <span class="glyphicon form-control-feedback"></span>
                                                            <span class="help-block with-errors"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group has-feedback">

                                                    <div class="col-md-6 col-lg-offset-3  inputGroupContainer">
                                                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                            <input class="form-control {$borderColor}" type="password" placeholder="confirmez le mot de passe" name="c-mdpp" />
                                                            <span class="glyphicon form-control-feedback"></span>
                                                            <span class="help-block with-errors"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"></label>
                                                    <div class="col-md-offset-5">
                                                        <button type="submit" class="form-control btn btns" name='inscprof' > Valider   <span class="glyphicon glyphicon-send"></span></button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div></div>
                        </div>
                        <script src="js/jquery-latest.js"></script>
                        <script src="js/js/bootstrap.min.js"></script>

                        <script src="js/jquery2.js"></script>
                        <script src="js/ajax13.js"></script>
                        <script src="js/jquery13.js"></script>
                        <script>
                            $(function () {

                                $.validator.setDefaults({
                                    highlight: function (element) {
                                        $(element).closest('.form-group').addClass('has-error');
                                    },
                                    unhighlight: function (element) {
                                        $(element).closest('.form-group').removeClass('has-error');
                                    },
                                    errorElement: 'span',
                                    errorClass: 'help-block',
                                    errorPlacement: function (error, element) {
                                        if (element.parent('.input-group').length) {
                                            error.insertAfter(element.parent());
                                        } else {
                                            error.insertAfter(element);
                                        }
                                    }
                                });
                                $.validator.addMethod('strongPassword', function (value, element) {
                                    return this.optional(element)
                                            || value.length >= 6
                                            && /\d/.test(value)
                                            && /[a-z]/i.test(value);
                                }, 'Votre mot de passe doit au minimum avoir 6 caracters et contient au moin un chiffre et un caractere\'.')

                                $("#reg_formpar").validate({
                                    rules: {

                                        nom: {
                                            required: true,
                                            lettersonly: true
                                        },
                                        prenom: {
                                            required: true,
                                            lettersonly: true
                                        },
                                        username: {
                                            required: true,
                                        },
                                        adresse: {
                                            required: true,
                                        },
                                        numtel: {
                                            required: true,
                                            digits: true,
                                            phoneUK: true,
                                        },
                                        email: {
                                            required: true,
                                            email: true,
                                        },
                                        mdp: {
                                            required: true,
                                            strongPassword: true
                                        },
                                        'c-mdp': {
                                            required: true,
                                            equalTo: '#mdp'
                                        }
                                    }
                                });
                                //profisionnel

                                $("#reg_formprof").validate({
                                    rules: {

                                        nomp: {
                                            required: true,
                                            lettersonly: true
                                        },
                                        prenomp: {
                                            required: true,
                                            lettersonly: true
                                        },
                                        usernamep: {
                                            required: true,
                                        },
                                        adressep: {
                                            required: true,
                                        },
                                        numtelp: {
                                            required: true,
                                            digits: true,
                                            phoneUK: true,
                                        },
                                        societe: {
                                            required: true,
                                        },
                                        site: {required: true,
                                            url: true,
                                        },

                                        emailp: {
                                            required: true,
                                            email: true,
                                        },
                                        mdpp: {
                                            required: true,
                                            strongPassword: true
                                        },
                                        'c-mdpp': {
                                            required: true,
                                            equalTo: '#mdpp',
                                        }
                                    }
                                });





                            });
                        </script>
                    </div>          
                </div>   </div>
        </div>  
    </body>
</html>
