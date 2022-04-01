<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MultiplAssur'</title>
    <meta charset="UTF-8">
    <meta name="description" content="MultiplAssur'">
    <meta name="author" content="Bertails Clément/Maurer Pierrick/Longuet Maxime/Darrigrand Fabien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="../assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/smoothproducts.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="managerHome.php"><i class=" text-light fas fa-home mr-3"></i>Accueil</a></li>
                    <li><a id='link' class="nav-link text-light" href='newContract.php'>Nouveau Contrat</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuranceMail.php'>Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='consultSinister.php'>Consulter Sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='consultSell.php'>Consulter ventes</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
        <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">
        <?php
            //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
            session_start();
            if (isset($_SESSION["profile"])) {
                if ($_SESSION["profile"] != 'manager') {
                    switch ($_SESSION["profile"]) {
                        case 'police':
                            header('Location: ../policeModule/policeHome.php?errorLogin=noAuthorized');
                            exit();
                            break;

                        case 'insured':
                            header('Location: ../insuredModule/insuredHome.php?errorLogin=noAuthorized');
                            exit();
                            break;

                        case 'admin':
                            header('Location: ../adminModule/adminHome.php?errorLogin=noAuthorized');
                            exit();
                            break;

                        default:
                            session_unset();
                            header('Location: ../visitorModule/connection.php?errorConnetion=notConnect');
                            exit();
                            break;
                    }
                }
            } else {
                session_unset();
                header('Location: ../visitorModule/connection.php?errorConnetion=notConnect');
                exit();
            }
            ?>
            <?php
            echo ('<br><br><br><br>');
            echo ('
                    <section class="clean-block clean-faq">
                        <div class="container">
                            <div class="block-heading">
                                <h2 class="text-info ">Bonjour ' . $_SESSION["login"] . '!</h2>
                ');
            if (isset($_GET['errorLogin'])) {
                if ($_GET['errorLogin'] == "noAuthorized") {
                    echo "<div class='faq-item'><h4 class='text-bold text-light'>Vous ne pouvez pas acceder a cette page. </h4></div>";
                }
            }
        ?>
        <div id="mailBox" class="text-light">
            <?php
                $allNewCoords = array();
                if ($data = json_decode(file_get_contents('../data/changeCoord.json'), true)) {
                    if (sizeof($data['changeCoord']) > 0) {
                        foreach ($data['changeCoord'] as $key => $newCoord) {
                            if ($newCoord['insurance'] == $_SESSION['company']) {
                                array_push($allNewCoords, $newCoord);
                            }
                        }
                        foreach ($allNewCoords as $key => $newCoord) {
                            echo "De : ".$newCoord['insuredName']." ".$newCoord['insuredFname'];
                            echo " | Changement de coordonnées";
                            echo "<div>";
                                echo (' <input class="button" type="button" name="validate" value="Lire" onclick="readMessage('.$key.')"><br>');
                                echo "<div id='".$key."' style='display:none'>";
                                    echo '<p>Nouvelle adresse : '.$newCoord["newAdress"].'</p>';
                                    echo '<p>Nouvelle ville : '.$newCoord["newCity"].'</p>';
                                    echo '<p>Nouveau code postal : '.$newCoord["newPostal"].'</p>';
                                    echo '<p>Nouveau pays : '.$newCoord["newCountry"].'</p>';
                                    $path = '../data/proofsAdress/'.$newCoord["insuredName"].$newCoord["insuredFname"];
                                    if (file_exists($path.'.png')) {
                                        echo '<p><a href="'.$path.'".png" download="preuve_de_changement.png">Télécharger la preuve du changement de coordonnées</a></p>';
                                        echo (' <input class="button" type="button" name="validate" value="Valider" onclick="validateChangeCoord(\''.$newCoord['insuredName'].'\',\''.$newCoord['insuredFname'].'\',\''.$newCoord['newAdress'].'\',\''.$newCoord['newCity'].'\',\''.$newCoord['newPostal'].'\',\''.$newCoord['newCountry'].'\')"><br>');
                                    } elseif (file_exists($path.'.jpg')) {
                                        echo '<p><a href="'.$path.'".jpg" download="preuve_de_changement.jpg">Télécharger la preuve du changement de coordonnées</a></p>';
                                        echo (' <input class="button" type="button" name="validate" value="Valider" onclick="validateChangeCoord(\''.$newCoord['insuredName'].'\',\''.$newCoord['insuredFname'].'\',\''.$newCoord['newAdress'].'\',\''.$newCoord['newCity'].'\',\''.$newCoord['newPostal'].'\',\''.$newCoord['newCountry'].'\')"><br>');
                                    } elseif (file_exists($path.'.jpeg')) {
                                        echo '<p><a href="'.$path.'".jpeg" download="preuve_de_changement.jpeg">Télécharger la preuve du changement de coordonnées</a></p>';
                                        echo (' <input class="button" type="button" name="validate" value="Valider" onclick="validateChangeCoord(\''.$newCoord['insuredName'].'\',\''.$newCoord['insuredFname'].'\',\''.$newCoord['newAdress'].'\',\''.$newCoord['newCity'].'\',\''.$newCoord['newPostal'].'\',\''.$newCoord['newCountry'].'\')"><br>');
                                    } elseif (file_exists($path.'.pdf')) {
                                        echo '<p><a href="'.$path.'".pdf" download="preuve_de_changement.pdf">Télécharger la preuve du changement de coordonnées</a></p>';
                                        echo (' <input class="button" type="button" name="validate" value="Valider" onclick="validateChangeCoord(\''.$newCoord['insuredName'].'\',\''.$newCoord['insuredFname'].'\',\''.$newCoord['newAdress'].'\',\''.$newCoord['newCity'].'\',\''.$newCoord['newPostal'].'\',\''.$newCoord['newCountry'].'\')"><br>');
                                    }
                                echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo '<h4 class="faq-item">Aucun changement de coordonnées touvé.</h4>';
                    }
                }
                
            ?>
        </div>
        <!-- <div id="response" class="text-light faq-item"></div> -->
        <script>
            //permet d'afficher le contenu du message lu
            function readMessage(id) {
                for (let i = 0; i < document.getElementById('mailBox').children.length; i++) {
                    document.getElementById('mailBox').children[i].children[2].style.display = "none";
                }
                document.getElementById(id).style.display = 'inherit';
            }
            //requete ajax permetant de valider le changement de coordonnées
            function validateChangeCoord(name, fname, adress, city, postalCode, country){
                // document.getElementById('response').innerHTML = "";
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // document.getElementById("response").innerHTML = this.responseText;
                    }
                }
                xhttp.open("POST", "validations.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send('changeCoord=ok&name='+name+'&fname='+fname+'&newAdress='+adress+'&newCity='+city+'&newPostalCode='+postalCode+'&newCountry='+country);
            }
        </script>
    </main>
    <footer class="page-footer bg-dark">

        <div class="bg-success">
            <div class="container">
                <div class="row py-4 d-flex align-items-center">

                    <div class="col-md-12 text-light text-center">
                        <a href="#"><i class="fab fa-facebook-f text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-twitter text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-google-plus-g text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-linkedin-in text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-instagram text-light white-text"> </i></a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container text-center text-light text-md-left mt-5">
            <div class="row">

                <div class="col-md-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">MultiplAssur'</h6>
                    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 125px; height: 2px">
                    <p class="mt-2">Nous sommes la pour vous aider</p>
                </div>

                <div class="col-md-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Contacts</h6>
                    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 75px; height: 2px">
                    <ul class="list-unstyled">
                        <li class="my-2"><i class="fas fa-home mr-3"></i> Paris 75800, avenue de la république</li>
                        <li class="my-2"><i class="fas fa-envelope mr-3"></i>multiplassur@gmail.com</li>
                        <li class="my-2"><i class="fas fa-phone mr-3"></i>06 95 48 62 15</li>
                        <li class="my-2"><i class="fas fa-print mr-3"></i>multiplassur@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-copyright text-light text-light white-text bg-dark text-center py-3">
            <p>&copy; Copyright
                <a href="#">@2021</a>
            </p>
            <p>Designed by Bertails, Darrigrand, Longuet, Maurer</p>
        </div>
    </footer>
</body>

</html>