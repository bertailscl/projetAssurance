<?php
session_start();
//permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
if (isset($_SESSION["profile"])) {
    switch ($_SESSION["profile"]) {
        case 'admin':
            header('Location: ../adminModule/adminHome.php');
            exit();
            break;

        case 'insured':
            if (!isset($_POST['list']) && !isset($_POST["scan"]) && !isset($_POST["contractList"])) {
                header('Location: insuredHome.php');
                exit();
            }
            break;

        case 'police':
            header('Location: ../policeModule/policeHome.php');
            exit();
            break;

        case 'manager':
            header('Location: ../managerModule/managerHome.php');
            exit();
            break;

        default:
            session_unset();
            header('Location: ../visitorModule/connection.php');
            exit();
            break;
    }
} else {
    session_unset();
    header('Location: ../visitorModule/connection.php');
    exit();
}
?>
<?php
if (isset($_POST["list"])) {
    echo ("<div class='text-light'>");
    echo "<label for='myContracts'>Vos Contrats : </label>";
    echo '<select id="myContracts" name="myContracts" required>';
    echo "<option value='' disabled selected hidden>Mes contrats</option>";
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => $insured) {
            $cars = $insured['car'];
            if ($insured['name'] == $_SESSION["name"] && $insured['fname'] == $_SESSION["fname"]) {
                foreach ($cars as $key => $car) {
                    echo "<option id='" . $car['greyCard']['A'] . "' value='" . $car['greyCard']['A'] . "'>" . $car['greyCard']['D_1'] . " " . $car['greyCard']['D_3'] . " " . $car['greyCard']['A'] . "</option>";
                }
            }
        }
    }
    echo ('</select>');
    echo '</div>';
    echo (' <input id="listSearchContract" class="button" type="button" name="listSearchContract" value="Afficher le contrat" onclick="showContract()">');
}
//permet d'afficher le contrat scanné
if (isset($_POST["scan"])) {
    if (isset($_SESSION["validity"]) && isset($_SESSION["insurance"]) && isset($_SESSION["immatriculation"]) && isset($_SESSION["contrat"])) {
        echo ("<div class='text-light'>");
        echo ("Le contrat scanné est le n°" . $_SESSION["contrat"] . "<br>");
        echo ("</div>");
        if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
            foreach ($data['insured'] as $key => $insured) {
                $cars = $insured['car'];
                foreach ($cars as $key => $car) {
                    if ($insured['name'] == $_SESSION["name"] && $insured['fname'] == $_SESSION["fname"] && $car['greenCard']['codes']['contractNumber'] == $_SESSION['contrat']) {
                        echo ("<div class='text-light'>");
                        echo ('<h2>Voici votre contrat</h2>');
                        echo '<div id="infoContract">';
                        echo ("<div>La voiture assurée est : " . $car['greyCard']['D_1'] . " " . $car['greyCard']['D_3'] . "</div>");
                        echo ("<div>Immatriculée : " . $car['greyCard']['A'] . "</div>");
                        echo ("<div>Vous avez ce contrat depuis le : " . $car['greenCard']['validityStart'] . "</div>");
                        echo ("<div>La validité de ce contrat se finira le : " . $car['greenCard']['validityEnd'] . "</div>");

                        echo ("<div>Conducteur/s principal/aux du vehicule : <br>" . $car['greenCard']['namesAndAdress']['name'] . " " . $car['greenCard']['namesAndAdress']['fname'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['adress'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['city'] . " " . $car['greenCard']['namesAndAdress']['postalCode'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['country'] . "</div>");

                        echo ("<div>Informations de l'assureur : <br>" . $car['greenCard']['insurerInfo']['name'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['adress'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['city'] . " " . $car['greenCard']['insurerInfo']['postalCode'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['country'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['phoneNumber'] . "</div>");
                        echo ('<input id="showGreenCardButton" class="button" type="button" name="showGreenCardButton" value="Afficher la carte verte" onclick="showGreenCard()">');
                        echo '</div>';
                        echo '<div id="showGreenCard" style="display: none;">';
                        echo ('<h1>Carte Verte</h1>');
                        echo ('<div id="1_2">');
                        echo ('<div id="1">');
                        echo ("<div>Carte Internationale d'assurance automobile.</div>");
                        echo ('</div>');
                        echo ('<div id="2">');
                        echo ("<div>Emise avec l'autorisation du bureau central français.</div>");
                        echo ('</div>');
                        echo ('</div>');
                        echo ('<div id="3_4">');
                        echo ('<div id="3">');
                        echo ("<div>Valable du " . $car['greenCard']['validityStart']);
                        echo (' au ' . $car['greenCard']['validityEnd'] . "</div>");
                        echo ('</div>');
                        echo ('<div id="4">');
                        echo ("<div>Code Pays / Code Assureur / Numéro de contrat : " . $car['greenCard']['codes']['countryCode'] . " / " . $car['greenCard']['codes']['insurerCode'] . " / " . $car['greenCard']['codes']['contractNumber'] . "</div>");
                        echo ('</div>');
                        echo ('</div>');
                        echo ('<div id="5_6_7">');
                        echo ('<div id="5">');
                        echo ("<div>Numéro d'immatriculation : " . $car['greenCard']['immatriculation'] . "</div>");
                        echo ('</div>');
                        echo ('<div id="6">');
                        echo ("<div>Catégorie du véhicule : " . $car['greenCard']['vehicleCategory'] . "</div>");
                        echo ('</div>');
                        echo ('<div id="7">');
                        echo ("<div>Marque du véhicule : " . $car['greenCard']['model'] . "</div>");
                        echo ('</div>');
                        echo ('</div>');
                        echo ('<div id="8">');
                        echo ("<div>Validité territoriale : | ");
                        $countriesValidity =  $car['greenCard']['countriesValidity'];
                        foreach ($countriesValidity as $key => $code) {
                            echo ($code . " | ");
                        }
                        echo ('</div>');
                        echo ('</div>');
                        echo ('<div id="9">');
                        echo ("<div>Nom et adresse du souscripteur de la police(ou de l'utilisateur du véhicule) : <br>" . $car['greenCard']['namesAndAdress']['name'] . " " . $car['greenCard']['namesAndAdress']['fname'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['adress'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['city'] . " " . $car['greenCard']['namesAndAdress']['postalCode'] . "<br>");
                        echo ($car['greenCard']['namesAndAdress']['country'] . "</div>");
                        echo ('</div>');
                        echo ('<div id="10">');
                        echo ("<div>Cette carte a été délivrée par : <br>" . $car['greenCard']['insurerInfo']['name'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['adress'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['city'] . " " . $car['greenCard']['insurerInfo']['postalCode'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['country'] . "<br>");
                        echo ($car['greenCard']['insurerInfo']['phoneNumber'] . "</div>");
                        echo ('</div>');
                        echo ('<div id="codeCategorieVehicle">');
                        echo ('<div><b>A.</b> Automobile ');
                        echo ('<b> B.</b> MOTOCYCLE ');
                        echo ('<b> C.</b> CAMION OU TRACTEUR ');
                        echo ('<b> D.</b> CYCLE A MOTEUR AUXILIAIRE ');
                        echo ('<b> E.</b> AUTOBUS ET AUTOCAR ');
                        echo ('<b> F.</b> REMORQUE ');
                        echo ('<b> G.</b> AUTRES</div>');
                        echo ('</div>');
                        echo '</div>';
                        echo ('<br>');
                        echo ("</div>");
                    } else {
                        echo ("<div class='text-light'>");
                        echo "<div>vous n'avez pas acces au détails de ce contrat</div>";
                        echo ("</div>");
                    }
                }
            }
        }
    } else {
        echo ("<div class='text-light'>");
        echo ("<div>Aucun contrat scanné.</div>");
        echo ("</div>");
    }
}
//permet d'afficher le contrat choisi parmis la liste des contrats de l'assuré
if (isset($_POST["contractList"])) {
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => $insured) {
            $cars = $insured['car'];
            foreach ($cars as $key => $car) {
                if ($insured['name'] == $_SESSION["name"] && $insured['fname'] == $_SESSION["fname"] && $car['greenCard']['immatriculation'] == $_POST['immatriculation']) {
                    echo ("<div class='text-light'>");
                    echo ("Le contrat choisi est le n°" . $car['greenCard']['codes']['contractNumber'] . "<br>");
                    echo ('<h2>Voici votre contrat</h2>');
                    echo '<div id="infoContract">';
                    echo ("<div>La voiture assurée est : " . $car['greyCard']['D_1'] . " " . $car['greyCard']['D_3'] . "</div>");
                    echo ("<div>Immatriculée : " . $car['greyCard']['A'] . "</div>");
                    echo ("<div>Vous avez ce contrat depuis le : " . $car['greenCard']['validityStart'] . "</div>");
                    echo ("<div>La validité de ce contrat se finira le : " . $car['greenCard']['validityEnd'] . "</div>");

                    echo ("<div>Conducteur/s principal/aux du vehicule : <br>" . $car['greenCard']['namesAndAdress']['name'] . " " . $car['greenCard']['namesAndAdress']['fname'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['adress'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['city'] . " " . $car['greenCard']['namesAndAdress']['postalCode'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['country'] . "</div>");

                    echo ("<div>Informations de l'assureur : <br>" . $car['greenCard']['insurerInfo']['name'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['adress'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['city'] . " " . $car['greenCard']['insurerInfo']['postalCode'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['country'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['phoneNumber'] . "</div>");
                    echo ('<input id="showGreenCardButton" class="button" type="button" name="showGreenCardButton" value="Afficher la carte verte" onclick="showGreenCard()">');
                    echo '</div>';
                    echo '<div id="showGreenCard" style="display: none;">';
                    echo ('<h1>Carte Verte</h1>');
                    echo ('<div id="1_2">');
                    echo ('<div id="1">');
                    echo ("<div>Carte Internationale d'assurance automobile.</div>");
                    echo ('</div>');
                    echo ('<div id="2">');
                    echo ("<div>Emise avec l'autorisation du bureau central français.</div>");
                    echo ('</div>');
                    echo ('</div>');
                    echo ('<div id="3_4">');
                    echo ('<div id="3">');
                    echo ("<div>Valable du " . $car['greenCard']['validityStart']);
                    echo (' au ' . $car['greenCard']['validityEnd'] . "</div>");
                    echo ('</div>');
                    echo ('<div id="4">');
                    echo ("<div>Code Pays / Code Assureur / Numéro de contrat : " . $car['greenCard']['codes']['countryCode'] . " / " . $car['greenCard']['codes']['insurerCode'] . " / " . $car['greenCard']['codes']['contractNumber'] . "</div>");
                    echo ('</div>');
                    echo ('</div>');
                    echo ('<div id="5_6_7">');
                    echo ('<div id="5">');
                    echo ("<div>Numéro d'immatriculation : " . $car['greenCard']['immatriculation'] . "</div>");
                    echo ('</div>');
                    echo ('<div id="6">');
                    echo ("<div>Catégorie du véhicule : " . $car['greenCard']['vehicleCategory'] . "</div>");
                    echo ('</div>');
                    echo ('<div id="7">');
                    echo ("<div>Marque du véhicule : " . $car['greenCard']['model'] . "</div>");
                    echo ('</div>');
                    echo ('</div>');
                    echo ('<div id="8">');
                    echo ("<div>Validité territoriale : | ");
                    $countriesValidity =  $car['greenCard']['countriesValidity'];
                    foreach ($countriesValidity as $key => $code) {
                        echo ($code . " | ");
                    }
                    echo ('</div>');
                    echo ('</div>');
                    echo ('<div id="9">');
                    echo ("<div>Nom et adresse du souscripteur de la police(ou de l'utilisateur du véhicule) : <br>" . $car['greenCard']['namesAndAdress']['name'] . " " . $car['greenCard']['namesAndAdress']['fname'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['adress'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['city'] . " " . $car['greenCard']['namesAndAdress']['postalCode'] . "<br>");
                    echo ($car['greenCard']['namesAndAdress']['country'] . "</div>");
                    echo ('</div>');
                    echo ('<div id="10">');
                    echo ("<div>Cette carte a été délivrée par : <br>" . $car['greenCard']['insurerInfo']['name'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['adress'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['city'] . " " . $car['greenCard']['insurerInfo']['postalCode'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['country'] . "<br>");
                    echo ($car['greenCard']['insurerInfo']['phoneNumber'] . "</div>");
                    echo ('</div>');
                    echo ('<div id="codeCategorieVehicle">');
                    echo ('<div><b>A.</b> Automobile ');
                    echo ('<b> B.</b> MOTOCYCLE ');
                    echo ('<b> C.</b> CAMION OU TRACTEUR ');
                    echo ('<b> D.</b> CYCLE A MOTEUR AUXILIAIRE ');
                    echo ('<b> E.</b> AUTOBUS ET AUTOCAR ');
                    echo ('<b> F.</b> REMORQUE ');
                    echo ('<b> G.</b> AUTRES</div>');
                    echo ('</div>');
                    echo '</div>';
                    echo ('<br>');
                    echo ("</div>");
                }
            }
        }
    }
}
?>