<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MultiplAssur'</title>
    <meta charset="UTF-8">
    <meta name="description" content="MultiplAssur'">
    <meta name="author" content="Bertails ClÃ©ment/Maurer Pierrick/Longuet Maxime/Darrigrand Fabien">
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
    //permet de deconnecter automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    session_start();
    if (isset($_SESSION["profile"])) {
        if ($_SESSION["profile"] != 'unconnect') {
            session_unset();
        }
    }
    ?>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="#"><i class=" text-light fas fa-home mr-3"></i>Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">

    <main class="page login-page">
        <section class="clean-block clean-form dark bg-dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Connexion</h2>
                </div>
                <form action="connectionVerification.php" method="POST">
                    <div class="form-group"><label for="login">Identifiant : </label><input class="form-control item" type="text" id="login" name="login"></div>
                    <div class="form-group"><label for="password">Mot de passe : </label><input class="form-control" type="password" id="password" name="password"></div>
                    <?php
                    //verifier ecrire un message en fonction du moyen de connexion a la page
                    // permet d'eviter d'acceder a d'autre page sans y être invité.
                    if (isset($_GET['errorConnection'])) {
                        if ($_GET['errorConnection'] == "errorConnection") {
                            echo "<div class='faq-item'><h4 class='text-bold text-dark'>Erreur de connexion veuillez réessayer.</h4></div>";
                        }
                        if ($_GET['errorConnection'] == "notConnect") {
                            echo "<div class='faq-item'><h4 class='text-bold text-dark'>Veuillez vous connecter pour accéder à cette page.</h4></div>";
                        }
                    }
                    ?>
                    <div class="form-group">
                        <div class="form-check"><input onclick="showPassword()" class="form-check-input" type="checkbox" id="checkbox"><label class="form-check-label" for="checkbox">Afficher le mot de passe</label></div>
                    </div><button class="btn btn-primary btn-block" type="submit">Se connecter</button>
                </form>
            </div>
        </section>
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

    <script>
        //permet d'afficher le mot de passe sous forme de text
        function showPassword() {
            var passValue = document.getElementById("password");
            if (passValue.type === "password") {
                passValue.type = "text";
            } else {
                passValue.type = "password";
            }
        }
    </script>
</body>

</html>