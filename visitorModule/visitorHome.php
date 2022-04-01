<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MultiplAssur'</title>
    <meta charset="UTF-8">
    <meta name="description" content="MultiplAssur'">
    <meta name="author" content="Bertails Clément/Maurer Pierrick/Longuet Maxime/Darrigrand Fabien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
    //permet de deconnecter automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    session_start();
    if (isset($_SESSION["profile"])) {
        if ($_SESSION["profile"] != 'unconnect') {
            session_unset();
        }
    }
    ?>
    <body>
        <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
            <div class="container"><p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link text-light" href="./connection.php"><i class="fas fa-sign-in-alt mr-3"></i>Se Connecter</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="page faq-page bg-dark">
        <br> <br>
        <?php
        if (isset($_GET["immatriculation"]) && isset($_GET["contrat"])) {
            session_unset();
            if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
                foreach ($data['insured'] as $key => $insured) {
                    $cars = $insured['car'];
                    foreach ($cars as $key => $car) {
                        if ($car['greyCard']['A'] == $_GET["immatriculation"] && $car['greenCard']['codes']['contractNumber'] == $_GET["contrat"]) {
                            $_SESSION["validity"] = $car['greenCard']['validityEnd'];
                            $_SESSION["insurance"] = $car['greenCard']['insurerInfo']['name'];
                            $_SESSION["immatriculation"] = $_GET["immatriculation"];
                            $_SESSION["contrat"] = $_GET["contrat"];
                            $_SESSION["profile"] = 'unconnect';
                            echo ('
                                <section class="clean-block clean-faq">
                                    <div class="container">
                                        <div class="block-heading">
                                            <h2 class="text-info">Informations</h2>
                                        </div>
                                        <div class=" block-content">
                                            <div class="faq-item">
                                                <h4 class="text-bold text-dark">Date de validité : <span class="answer text-bold">' . $_SESSION["validity"] . '</span></h4>
                                            </div>
                                            <div class="faq-item">
                                                <h4 class="text-bold text-dark">Assurance : <span class="answer text-bold">' . $_SESSION["insurance"] . '</span></h4>
                                            </div>
                                            <div class="faq-item">
                                                <h4 class="text-bold text-dark">Immatriculation : <span class="answer text-bold">' . $_SESSION["immatriculation"] . '</span></h4>
                                            </div>
                                            <div class="faq-item">
                                                <h4 class="text-bold text-dark">Contrat n° : <span class="answer text-bold">' . $_SESSION["contrat"] . '</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            ');
                        }
                    }
                }
            }
            if (!isset($_SESSION["profile"])) {
                //si les parmetres du qr code sont mal lu, afficher ce message
                echo ("
                    <section class='clean-block clean-faq'>
                        <div class='container'>
                            <div class='block-heading'>
                                <h2 class='text-info'>Informations</h2>
                            </div>
                            <div class=' block-content'>
                                <div class='faq-item'>
                                    <h4 class='text-bold text-dark'>Une erreur s'est produite, veuillez rescanner le code QR.</h4>
                                </div>
                            </div>
                        </div>
                    </section>
                ");
            }
        } elseif (isset($_SESSION["profile"]) and $_SESSION["profile"] == 'unconnect') {
            echo ('
                <section class="clean-block clean-faq">
                    <div class="container">
                        <div class="block-heading">
                            <h2 class="text-info">Informations</h2>
                        </div>
                        <div class=" block-content">
                            <div class="faq-item">
                                <h4 class="text-bold text-dark">Date de validité : <span class="answer text-bold">' . $_SESSION["validity"] . '</span></h4>
                            </div>
                            <div class="faq-item">
                                <h4 class="text-bold text-dark">Assurance : <span class="answer text-bold">' . $_SESSION["insurance"] . '</span></h4>
                            </div>
                            <div class="faq-item">
                                <h4 class="text-bold text-dark">Immatriculation : <span class="answer text-bold">' . $_SESSION["immatriculation"] . '</span></h4>
                            </div>
                            <div class="faq-item">
                                <h4 class="text-bold text-dark">Contrat n° : <span class="answer text-bold">' . $_SESSION["contrat"] . '</span></h4>
                            </div>
                        </div>
                    </div>
                </section>
            ');
        } else {
            //si les parmetres du qr code sont mal lu, afficher ce message
            echo("
                <section class='clean-block clean-faq'>
                    <div class='container'>
                        <div class='block-heading'>
                            <h2 class='text-info'>Informations</h2>
                        </div>
                        <div class=' block-content'>
                            <div class='faq-item'>
                                <h4 class='text-bold text-dark'>Une erreur s'est produite, veuillez rescanner le code QR.</h4>
                            </div>
                        </div>
                    </div>
                    <br>
                </section>
            ");
        }
        ?>
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