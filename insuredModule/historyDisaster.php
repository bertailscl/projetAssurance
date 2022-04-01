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
    <?php
    //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    session_start();
    if (isset($_SESSION["profile"])) {
        if ($_SESSION["profile"] != 'insured') {
            switch ($_SESSION["profile"]) {
                case 'police':
                    header('Location: ../policeModule/policeHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                case 'admin':
                    header('Location: ../adminModule/adminHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                case 'manager':
                    header('Location: ../managerModule/managerHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                default:
                    session_unset();
                    header('Location: ../visitorModule/connection.php?errorConnection=notConnect');
                    exit();
                    break;
            }
        }
    } else {
        session_unset();
        header('Location: ../visitorModule/connection.php?errorConnection=notConnect');
        exit();
    }
    ?>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="insuredHome.php"><i class=" text-light fas fa-home mr-3"></i>Accueil</a></li>
                    <li><a id='link' class="nav-link text-light" href='changeCoord.php'>Coordonnées</a></li>
                    <li><a id='link' class="nav-link text-light" href='declareDisaster.php'>Déclarer sinistre</a></li>
                    <li><a id='link' class="nav-link text-light" href='sellVehicle.php'>Vente</a></li>
                    <li><a id='link' class="nav-link text-light" href='historyDisaster.php'> Historique sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuredMail.php'></i> Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
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
            echo ('</div>');
            echo ("<div id='infoDisaster'>");
            if ($data = json_decode(file_get_contents('../data/disaster.json'), true)) {
                if (sizeof($data['disaster']) > 0 ) {
                    foreach ($data['disaster'] as $key => $disaster) {
                        if ($disaster['insuredName'] == $_SESSION["name"] && $disaster['insuredFname'] == $_SESSION["fname"]) {
                            echo '<h3>Votre déclaration de sinistre :</h3>';
                            echo '<label class="text-light faq-item" for="name">Nom : </label>';
                            echo '<input id="name" name="name" type="text" value="' . $disaster['insuredName'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="fname">Prénom : </label>';
                            echo '<input id="fname" name="fname" type="text" value="' . $disaster['insuredFname'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="vehicle">Votre véhicule : </label>';
                            echo '<input id="vehicle" name="vehicle" type="text" value="' . $disaster['vehicle'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="disasterDate">Date du sinistre : </label>';
                            echo '<input id="disasterDate" name="disasterDate" type="text" value="' . $disaster['disasterDate'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="circonstances">Circonstances du sinistre : </label>';
                            echo '<input id="circonstances" name="circonstances" type="text" value="' . $disaster['circonstances'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="damageNature">Nature des dommages : </label>';
                            echo '<input id="damageNature" name="damageNature" type="text" value="' . $disaster['damageNature'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="nbOfInjured">Nombre de blessés : </label>';
                            echo '<input id="nbOfInjured" name="nbOfInjured" type="text" value="' . $disaster['nbOfInjured'] . '" required disabled><br><br>';
                            echo '<label class="text-light faq-item" for="garage">Nom et adresse du garagiste où le véhicule est (ou sera) visible : </label>';
                            echo '<input id="garage" name="garage" type="text" value="' . $disaster['garage'] . '" disabled><br><br>';
                            echo '<label class="text-light faq-item" for="garageDispoDate">A partir de : </label>';
                            echo '<input id="garageDispoDate" name="garageDispoDate" type="text" value="' . $disaster['garageDispoDate'] . '" disabled><br><br>';
                            echo '<label class="text-light faq-item" for="garagePhone">Numéro du garagiste : </label>';
                            echo '<input id="garagePhone" name="garagePhone" type="text" value="' . $disaster['garagePhone'] . '" disabled><br><br>';
                        }
                    }
                }
            }
            echo ("</div>");
        echo ('</div>');
        ?>
        <script>
            if (document.getElementById('infoDisaster').innerHTML == "") {
                document.getElementById('infoDisaster').innerHTML = "<h4 class='text-light faq-item text-bold' style='text-align:center'>Vous n'avez actuellement déclaré aucun sinistre.</h4>";
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