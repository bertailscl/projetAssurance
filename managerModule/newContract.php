<!DOCTYPE html>
<html lang="fr">

<head>
    <title>I-Car</title>
    <meta charset="UTF-8">
    <meta name="description" content="I-Car">
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
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li><a id='link' class="nav-link text-light" href='managerHome.php'>Accueil</a></p>
                    <li><a id='link' class="nav-link text-light" href='insuranceMail.php'>Messagerie</a></p>
                    <li><a id='link' class="nav-link text-light" href='consultSinister.php'>Consulter Sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='consultSell.php'>Consulter ventes</a></li>
                    <li><a id='link' class="nav-link text-light" href='validateChangeCoord.php'>Changement coordonnées</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'>Se déconnecter</a></p>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
        <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">
        <?php
        echo ('
                <section class="clean-block clean-faq">
                    <div class="container">
                        <div class="block-heading">
                            <h2 class="text-info">Bonjour ' . $_SESSION["login"] . '!</h2>
            ');
        if (isset($_GET['errorLogin'])) {
            if ($_GET['errorLogin'] == "noAuthorized") {
                echo "<div class='faq-item'><h4 class='text-bold text-light'>Vous ne pouvez pas acceder a cette page. </h4></div>";
            }
        }
        ?>
            <div id="contractsList" class="text-light">
                <form id='formNewContract' name="formNewContract">
                    <label for="name">Nom du demandeur d'assurance : </label><input name="name" type="text" placeholder="Nom" required><br>
                    <label for="fname">Prénom du demandeur d'assurance : </label><input name="fname" type="text" placeholder="Prénom" required><br>
                    <label for="phoneNumber">Tel : </label><input name="phoneNumber" type="text" placeholder="Téléphone" required><br>
                    <label for="mail">Mail : </label><input name="mail" type="text" placeholder="exemple@exemple.ex" required><br>
                    <label for="adress">Adresse : </label><input name="adress" type="text" placeholder="Adresse" oninput="this.value = this.value.toUpperCase()" required><br>
                    <label for="city">Ville : </label><input name="city" type="text" placeholder="Ville" oninput="this.value = this.value.toUpperCase()" required><br>
                    <label for="postalCode">Code postal : </label><input name="postalCode" type="text" placeholder="Code postal" oninput="this.value = this.value.toUpperCase()" required><br>
                    <label for="country">Pays : </label><input name="country" type="text" placeholder="Pays" oninput="this.value = this.value.toUpperCase()" required><br>
                    <div id='greyCard'>
                        <h2>Carte grise</h2>
                        <label for="A">A : </label><input name="A" type="text" placeholder="A" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="B">B : </label><input name="B" type="date" required><br>
                        <label for="C_1_fname">C.1 Nom : </label><input name="C_1_fname" type="text" placeholder="C.1 Nom" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="C_1_name">C.1 Prénom : </label><input name="C_1_name" type="text" placeholder="C.1 Prénom" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="C_3_adress">C.3 Adress : </label><input name="C_3_adress" type="text" placeholder="C.3 Adress" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="C_3_postal">C.3 Code Postal : </label><input name="C_3_postal" type="text" placeholder="C.3 Code Postal" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="C_3_city">C.3 Ville : </label><input name="C_3_city" type="text" placeholder="C.3 Ville" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="C_3_country">C.3 Pays : </label><input name="C_3_country" type="text" placeholder="C.3 Pays" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="D_1">D.1 : </label><input name="D_1" type="text" placeholder="D.1" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="D_2">D.2 : </label><input name="D_2" type="text" placeholder="D.2" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="D_2_1">D.2.1 : </label><input name="D_2_1" type="text" placeholder="D.2.1" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="D_3">D.3 : </label><input name="D_3" type="text" placeholder="D_3" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="E">E : </label><input name="E" type="text" placeholder="E" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="F_1">F.1 : </label><input name="F_1" type="text" placeholder="F.1" required><br>
                        <label for="F_2">F.2 : </label><input name="F_2" type="text" placeholder="F.2" required><br>
                        <label for="F_3">F.3 : </label><input name="F_3" type="text" placeholder="F.3" required><br>
                        <label for="G">G : </label><input name="G" type="text" placeholder="G" required><br>
                        <label for="G_1">G.1 : </label><input name="G_1" type="text" placeholder="G.1" required><br>
                        <label for="J">J : </label><input name="J" type="text" placeholder="J" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="J_1">J.1 : </label><input name="J_1" type="text" placeholder="J.1" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="J_2">J.2 : </label><input name="J_2" type="text" placeholder="J.2" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="J_3">J.3 : </label><input name="J_3" type="text" placeholder="J.3" oninput="this.value = this.value.toUpperCase()" required><br>
                        <label for="K">K : </label><input name="K" type="text" placeholder="K" required><br>
                        <label for="P_1">P.1 : </label><input name="P_1" type="text" placeholder="P.1" required><br>
                        <label for="P_2">P.2 : </label><input name="P_2" type="text" placeholder="P.2" required><br>
                        <label for="P_3">P.3 : </label>
                        <select id="P_3" name="P_3" required>
                            <option value='' disabled selected hidden>P.3</option>
                            <option id="AC" value="AC">Air comprimé (AC)</option>
                            <option id="EE" value="EE">Essence électricité (EE)</option>
                            <option id="EG" value="EG">Bicarburation essence-GPL (EG)</option>
                            <option id="EH" value="EH">Essence-électricité (EH)</option>
                            <option id="EL" value="EL">Electricité (EL)</option>
                            <option id="EM" value="EM">Bicarburation essence-gaz naturel et électricité (EM)</option>
                            <option id="EN" value="EN">Bicarburation essence-gaz naturel (EN)</option>
                            <option id="EP" value="EP">Bicarburation essence-gaz naturel et électricité (EP)</option>
                            <option id="EQ" value="EQ">Bicarburation essence-GPL et électricité (EQ)</option>
                            <option id="ER" value="ER">Bicarburation essence-GPL et électricité (ER)</option>
                            <option id="ES" value="ES">Essence (ES)</option>
                            <option id="ET" value="ET">Ethanol (ET)</option>
                            <option id="FE" value="FE">Superéthanol (FE)</option>
                            <option id="FG" value="FG">Bicarburation superéthanol-GPL (FG)</option>
                            <option id="FL" value="FL">Superéthanol-électricité (FL)</option>
                            <option id="FN" value="FN">Bicarburation superéthanol-gaz naturel ()</option>
                            <option id="GA" value="GA">Gazogène (GA)</option>
                            <option id="GE" value="GE">Mélange gazogène-essence (GE)</option>
                            <option id="GF" value="GF">Mélange de gazole et gaz naturel (GF)</option>
                            <option id="GG" value="GG">Mélange gazogène-gazole (GG)</option>
                            <option id="GH" value="GH">Gazole-électricité (GH)</option>
                            <option id="GL" value="GL">Gazole-électricité (GL)</option>
                            <option id="GM" value="GM">Mélange de gazole et gaz naturel et électricité (GM)</option>
                            <option id="GN" value="GN">Gaz naturel (GN)</option>
                            <option id="GO" value="GO">Gazole (GO)</option>
                            <option id="GP" value="GP">Gaz de pétrole liquéfié (GP)</option>
                            <option id="GPL" value="GPL">GPL (GPL)</option>
                            <option id="GQ" value="GQ">Mélange de gazole et gaz naturel et électricité (GQ)</option>
                            <option id="GZ" value="GZ">Autres hydrocarbures gazeux comprimés (GZ)</option>
                            <option id="H2" value="H2">Hydrogène (H2)</option>
                            <option id="NE" value="NE">Gaz naturel-électricité (NE)</option>
                            <option id="NH" value="NH">Gaz naturel-électricité (NH)</option>
                            <option id="PE" value="PE">Monocarburation GPL-électricité (PE)</option>
                            <option id="PH" value="PH">Monocarburation GPL-électricité (PH)</option>
                            <option id="PL" value="PL">Pétrole lampant (PL)</option>
                        </select><br>
                        <label for="P_6">P.6 : </label><input name="P_6" type="text" placeholder="P.6" required><br>
                        <label for="Q">Q : </label><input name="Q" type="text" placeholder="Q"><br>
                        <label for="S_1">S.1 : </label><input name="S_1" type="text" placeholder="S.1" required><br>
                        <label for="S_2">S.2 : </label><input name="S_2" type="text" placeholder="S.2"><br>
                        <label for="U_1">U.1 : </label><input name="U_1" type="text" placeholder="U.1" required><br>
                        <label for="U_2">U.2 : </label><input name="U_2" type="text" placeholder="U.2" required><br>
                        <label for="V_7">V.7 : </label><input name="V_7" type="text" placeholder="V.7" required><br>
                        <label for="V_9">V.9 : </label><input name="V_9" type="text" placeholder="V.9" required><br>
                        <label for="X_1">X.1 : </label><input name="X_1" type="date" required><br>
                        <label for="Y_1">Y.1 : </label><input name="Y_1" type="text" placeholder="Y.1" required><br>
                        <label for="Y_2">Y.2 : </label><input name="Y_2" type="text" placeholder="Y.2" required><br>
                        <label for="Y_3">Y.3 : </label><input name="Y_3" type="text" placeholder="Y.3" required><br>
                        <label for="Y_4">Y.4 : </label><input name="Y_4" type="text" placeholder="Y.4" required><br>
                        <label for="Y_5">Y.5 : </label><input name="Y_5" type="text" placeholder="Y.5" required><br>
                        <label for="Y_6">Y.6 : </label><input name="Y_6" type="text" placeholder="Y.6" required><br>
                        <label for="H">H : </label><input name="H" type="text" placeholder="H"><br>
                        <label for="I">I : </label><input name="I" type="date" required><br>
                        <label for="Z_1">Z.1 : </label><input name="Z_1" type="text" placeholder="Z.1"><br>
                        <label for="Z_2">Z.2 : </label><input name="Z_2" type="text" placeholder="Z.2"><br>
                        <label for="Z_3">Z.3 : </label><input name="Z_3" type="text" placeholder="Z.3"><br>
                        <label for="Z_4">Z.4 : </label><input name="Z_4" type="text" placeholder="Z.4"><br>
                        <h2>Certificat d'immatriculation</h2>
                        <label for="code">Caractéristiques du véhicule : </label><input name="code" type="text" placeholder="Caractéristiques du véhicule" required><br>
                    </div>
                    <div id='greenCard'>
                        <h2>Carte verte</h2>
                        <label for="validityStart">Date de début de validité du contrat : </label><input name="validityStart" type="date" required><br>
                            <h2>Catégorie du véhicule</h2>
                            <input name="vehicleType" type="radio" value="A" id="vehicleTypeA"><label for="vehicleTypeA">Automobile</label>
                            <input name="vehicleType" type="radio" value="B" id="vehicleTypeB"><label for="vehicleTypeB">Motocycle</label>
                            <input name="vehicleType" type="radio" value="C" id="vehicleTypeC"><label for="vehicleTypeC">Camion ou tracteur</label>
                            <input name="vehicleType" type="radio" value="D" id="vehicleTypeD"><label for="vehicleTypeD">Cycle à moteur auxiliaire</label>
                            <input name="vehicleType" type="radio" value="E" id="vehicleTypeE"><label for="vehicleTypeE">Autobus et autocar</label>
                            <input name="vehicleType" type="radio" value="F" id="vehicleTypeF"><label for="vehicleTypeF">Remorque</label>
                            <input name="vehicleType" type="radio" value="G" id="vehicleTypeG"><label for="vehicleTypeG">Autres</label><br>
                                <h2>Informations du conducteur principal</h2>
                            <label for="1stConductorFname">Nom : </label><input name="1stConductorFname" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="Nom" required><br>
                            <label for="1stConductorName">Prénom : </label><input name="1stConductorName" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="Prénom" required><br>
                            <label for="1stConductorAdress">Adresse : </label><input name="1stConductorAdress" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="Adresse" required><br>
                            <label for="1stConductorCity">Ville : </label><input name="1stConductorCity" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="Ville" required><br>
                            <label for="1stConductorPostalCode">Code postal : </label><input name="1stConductorPostalCode" oninput="this.value = this.value.toUpperCase()" type="text" placeholder="Code postal" required><br>
                            <label for="1stConductorCountry">Pays : </label><input name="1stConductorCountry" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="Pays" required><br>
                        <br><input name="sendFormBtn" type="button" value="Créer le contrat" onclick="sendForm()">
                    </div>
                </form>
            </div>
            <div id="error" class="text-light faq-item"></div>
        </main>
        <script>
            //verifier et enregistrer les informations du nouveau contrat
            function sendForm() {
                document.getElementById("error").innerHTML = "";
                var formData = new FormData(document.getElementById('formNewContract'));
                if (formData.get("name") != null && formData.get("fname") != null && formData.get("phoneNumber") != null && formData.get("mail") != null && formData.get("adress") != null && formData.get("city") != null && formData.get("postalCode") != null && formData.get("country") != null && formData.get("A") != null && formData.get("B") != null && formData.get("C_1_name") != null && formData.get("C_1_fname") != null && formData.get("C_3_adress") != null && formData.get("C_3_postal") != null && formData.get("C_3_city") != null && formData.get("C_3_country") != null && formData.get("D_1") != null && formData.get("D_2") != null && formData.get("D_2_1") != null && formData.get("D_3") != null && formData.get("E") != null && formData.get("F_1") != null && formData.get("F_2") != null && formData.get("F_3") != null && formData.get("G") != null && formData.get("G_1") != null && formData.get("J") != null && formData.get("J_1") != null && formData.get("J_2") != null && formData.get("J_3") != null && formData.get("K") != null && formData.get("P_1") != null && formData.get("P_2") != null && formData.get("P_3") != null && formData.get("P_6") != null && formData.get("S_1") != null && formData.get("U_1") != null && formData.get("U_2") != null && formData.get("V_7") != null && formData.get("V_9") != null && formData.get("X_1") != null && formData.get("Y_1") != null && formData.get("Y_2") != null && formData.get("Y_3") != null && formData.get("Y_4") != null && formData.get("Y_5") != null && formData.get("Y_6") != null && formData.get("I") != null && formData.get("code") != null && formData.get("validityStart") != null && formData.get("validityStart") != null && formData.get("vehicleType") != null && formData.get("1stConductorName") != null && formData.get("1stConductorFname") != null && formData.get("1stConductorAdress") != null && formData.get("1stConductorCity") != null && formData.get("1stConductorPostalCode") != null && formData.get("1stConductorCountry") != null) {
                    var phoneNumberTmp = "";
                    if (formData.get("phoneNumber").split(' ').length > 1) {
                        for (let i = 0; i < formData.get("phoneNumber").split(' ').length; i++) {
                            phoneNumberTmp += formData.get("phoneNumber").split(' ')[i];
                        }
                        formData.set("phoneNumber", phoneNumberTmp);
                    }
                    var postalCodeTmp = "";
                    if (formData.get("postalCode").split(' ').length > 1) {
                        for (let i = 0; i < formData.get("postalCode").split(' ').length; i++) {
                            postalCodeTmp += formData.get("postalCode").split(' ')[i];
                        }
                        formData.get("postalCode") = postalCodeTmp;
                    }
                    var stConductorPostalCodeTmp = "";
                    if (formData.get("1stConductorPostalCode").split(' ').length > 1) {
                        for (let i = 0; i < formData.get("1stConductorPostalCode").split(' ').length; i++) {
                            stConductorPostalCodeTmp += formData.get("1stConductorPostalCode").split(' ')[i];
                        }
                        formData.get("1stConductorPostalCode") = stConductorPostalCodeTmp;
                    }
                    var C_3_postalTmp = "";
                    if (formData.get("C_3_postal").split(' ').length > 1) {
                        for (let i = 0; i < formData.get("C_3_postal").split(' ').length; i++) {
                            C_3_postalTmp += formData.get("C_3_postal").split(' ')[i];
                        }
                        formData.get("C_3_postal") = C_3_postalTmp;
                    }
                    formData.set('B', transformDate(formData.get("B")));
                    formData.set('X_1', transformDate(formData.get("X_1")));
                    formData.set('I', transformDate(formData.get("I")));
                    values = verifyValidityDate(formData.get("validityStart"));
                    formData.set('validityStart', values[0]);
                    formData.append('validityEnd', values[1]);
                    if (formData.get("phoneNumber").length == 10 && isNumeric(formData.get("phoneNumber")) && formData.get("postalCode").length == 5 && isNumeric(formData.get("postalCode")) && formData.get("B") != false && isNumeric(formData.get("F_1")) && isNumeric(formData.get("F_2")) && isNumeric(formData.get("F_3")) && isNumeric(formData.get("G")) && isNumeric(formData.get("G_1")) && isNumeric(formData.get("P_1")) && isNumeric(formData.get("P_6")) && isNumeric(formData.get("S_1")) && isNumeric(formData.get("U_1")) && isNumeric(formData.get("U_2")) && isNumeric(formData.get("V_7")) && formData.get("X_1") != false && isNumeric(formData.get("Y_1")) && isNumeric(formData.get("Y_2")) && isNumeric(formData.get("Y_3")) && isNumeric(formData.get("Y_4")) && isNumeric(formData.get("Y_5")) && isNumeric(formData.get("Y_6")) && formData.get("I") != false && (formData.get("validityStart") != false || formData.get("validityStart") != "passed") && formData.get("1stConductorPostalCode").length == 5 && isNumeric(formData.get("1stConductorPostalCode")) && formData.get("C_3_postal").length == 5 && isNumeric(formData.get("C_3_postal"))) {
                        formData.append("form", true);
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("contractsList").innerHTML = this.responseText;
                            }
                        }
                        xhttp.open("POST", "createContract.php", true);
                        xhttp.send(formData);
                    } else if (formData.get("phoneNumber").length != 10 || !isNumeric(formData.get("phoneNumber"))) {
                        if (formData.get("phoneNumber").length != 10) {
                            document.getElementById("error").innerHTML = "<p><B>Erreur, le format du nouveau numéro n'est pas valide. (bon format : 0000000000 ou 00 00 00 00 00)</B></p>";
                            return;
                        } else {
                            document.getElementById("error").innerHTML = "<p><B>Erreur, le numéro de téléphone saisi n'est pas valide.</B></p>";
                            return;
                        }
                    } else if (formData.get("B") == false) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, B n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("F_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, F.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("F_2"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, F.2 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("F_3"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, F.3 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("G"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, G n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("G_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, G.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("P_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, P.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("P_6"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, P.6 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("S_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("U_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("U_2"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("V_7"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_1"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_2"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_3"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_4"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_5"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (!isNumeric(formData.get("Y_6"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, S.1 n'est pas correctement saisi.</B></p>";
                        return;
                    } else if (formData.get('postalCode').length != 5 || !isNumeric(formData.get('postalCode')) || formData.get("1stConductorPostalCode").length != 5 || !isNumeric(formData.get("1stConductorPostalCode")) || formData.get("C_3_postal").length != 5 || !isNumeric(formData.get("C_3_postal"))) {
                        document.getElementById("error").innerHTML = "<p><B>Erreur, un des codes postals saisi n'est pas valide.</B></p>";
                        return;
                    } else if (formData.get("validityStart") == false || formData.get("validityStart") == "passed") {
                        if (formData.get("validityStart") == false) {
                            document.getElementById("error").innerHTML = "<p><B>Erreur, la date choisie n'est pas valide.</B></p>";
                            return;
                        } else {
                            document.getElementById("error").innerHTML = "<p><B>Erreur, la date choisie est passée.</B></p>";
                            return;
                        }
                    }
                } else {
                    document.getElementById("error").innerHTML = "<p><B>Erreur, une des valeurs obligatoire est manquante.</B></p>";
                }
            }
            //verifie que tout les caractères d'une chaine sont numériques
            function isNumeric(nb) {
                for (let i = 0; i < nb.length; i++) {
                    if (isNaN(nb.split("")[i])) {
                        return (false);
                    }
                }
                return (true);
            }
            //permet de mettre en forme une date
            function transformDate(date) {
                if (date != "" && date.split("-")[2] != null) {
                    var dd = date.split("-")[2];
                    var mm = date.split("-")[1];
                    var yyyy = date.split("-")[0];
                    if (dd < 10) {
                        dd = '0' + dd;
                    }
                    if (mm < 10) {
                        mm = '0' + mm;
                    }
                    return (dd + "/" + mm + "/" + yyyy);
                } else {
                    return false;
                }
            }
            //permet de verifier la date de validité entrée par l'utilisateur
            function verifyValidityDate(date) {
                if (date != "" && date.split("-")[2] != null) {
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth() + 1;
                    var yyyy = today.getFullYear();
                    if (dd < 10) {
                        dd = '0' + dd
                    }
                    if (mm < 10) {
                        mm = '0' + mm
                    }
                    var dateStart = new Date();
                    var dateEnd = new Date();
                    if (date.split("-")[0] > yyyy || date.split("-")[0] <= yyyy && date.split("-")[1] > mm || date.split("-")[0] <= yyyy && date.split("-")[1] <= mm && date.split("-")[2] >= dd) {
                        d = date.split("-")[2];
                        m = date.split("-")[1];
                        y = parseInt(date.split("-")[0]) + 1;
                        newValidityStart = d + "/" + m + "/" + date.split("-")[0];
                        newValidityEnd = d + "/" + m + "/" + y;
                        return [newValidityStart, newValidityEnd];
                    } else {
                        return ['passed', 'passed'];
                    }
                } else {
                    return [false, false];
                }
            }
        </script>
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