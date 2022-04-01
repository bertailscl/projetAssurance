<?php
session_start();
if (isset($_SESSION["profile"])) {
    switch ($_SESSION["profile"]) {
        case 'admin':
            header('Location: ../adminModule/adminHome.php');
            exit();
            break;

        case 'insured':
            if (!isset($_POST["rstform"]) && !isset($_POST["newLogin"]) && !isset($_POST["oldPassword"]) && !isset($_POST["newPhoneNumber"]) && !isset($_POST["newMail"]) && !isset($_POST["newAdress"])) {
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

//permet de d'afficher dynamiquement les informations de l'assuré
if (isset($_POST["rstform"])) {
    echo ("<div class='text-light'>");
    echo ('<div id="login_password">');
    echo '<label for="login">Mon identifiant :</label>';
    echo '<input id="login" name="login" type="text" value="' . $_SESSION["login"] . '" required><br><br>';
    echo '<input type="button" onclick="editLogin()" name="button" value="Modifier identifiant"><br><br>';
    if ($_POST["idIsModif"] === "login") {
        echo '<B>Votre identifiant a bien été modifié.</B><br><br>';
    }
    echo '<label for="oldPassword">Votre ancien mot de passe : </label>';
    echo '<input id="oldPassword" name="oldPassword" type="password" placeholder="mot de passe" required><br><br>';
    echo '<label for="newPassword">Nouveau mot de passe : </label>';
    echo '<input id="newPassword" name="newPassword" type="password" placeholder="mot de passe" required><br><br>';
    echo '<label for="confirmNewPassword">Confirmer nouveau mot de passe : </label>';
    echo '<input id="confirmNewPassword" name="confirmNewPassword" type="password" placeholder="mot de passe" required><br><br>';
    echo '<input type="checkbox" onclick="showPassword()"> Voir les mots de passe <br><br>';
    echo '<input type="button" onclick="editPassword()" name="button" value="Modifier le mot de passe"><br><br>';
    if ($_POST["idIsModif"] === "password") {
        echo '<B>Votre mot de passe a bien été modifié.</B><br>';
    }
    echo ('</div>');
    echo ('</div>');
    echo ('<div id="othersInfos">');
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => $insured) {
            if (isset($insured['name']) && isset($insured['fname'])) {
                if ($_SESSION['name'] == $insured['name'] && $_SESSION['fname'] == $insured['fname']) {
                    echo ("<div class='text-light'>");
                    echo '<label for="phoneNumber">Tel : </label>';
                    echo '<input id="phoneNumber" name="phoneNumber" type="text" value="' . $insured['phoneNumber'] . '" required><br><br>';
                    echo '<input type="button" onclick="editPhoneNumber()" name="button" value="Modifier numéro de téléphone"><br><br>';
                    echo ("</div>");
                    if ($_POST["idIsModif"] == "phone") {
                        echo ("<div class='text-light'>");
                        echo '<B>Votre numéro de téléphone a bien été modifié.</B><br><br>';
                        echo "</div>";
                    }
                    echo ("<div class='text-light'>");
                    echo '<label for="mail">Mail : </label>';
                    echo '<input id="mail" name="mail" type="email" placeHolder="myMail@example.com" value="' . $insured['mail'] . '" required><br><br>';
                    echo '<input type="button" onclick="editMail()" name="button" value="Modifier Mail"><br><br>';
                    echo ("</div>");
                    if ($_POST["idIsModif"] == "mail") {
                        echo ("<div class='text-light'>");
                        echo '<B>Votre mail a bien été modifié.</B><br><br>';
                        echo ("</div>");
                    }
                    echo ("<div class='text-light'>");
                    echo '<label for="adress">Adresse : </label>';
                    echo '<input id="adress" name="adress" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['adress'] . '" required><br><br>';
                    echo '<label for="city">Ville : </label>';
                    echo '<input id="city" name="city" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['city'] . '" required><br><br>';
                    echo '<label for="postalCode">Code postal : </label>';
                    echo '<input id="postalCode" name="postalCode" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['postalCode'] . '" required><br><br>';
                    echo '<label for="country">Pays : </label>';
                    echo '<input id="country" name="country" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['country'] . '" required><br><br>';
                    echo '<label for="proofAdress">Choisissez un justificatif de domicile : </label><br><br>';
                    echo '<input id="proofAdress" name="proofAdress" type="file" accept=".pdf, .png, .jpg, .jpeg"><br><br>';
                    echo "<input type='button' onclick='changeAdress()' name='button' value='Modifier mon adresse'><br><br>";
                    echo ("</div>");
                    if ($_POST["idIsModif"] == "adress") {
                        echo ("<div class='text-light'>");
                        echo "<B>Votre demande de changement d'adresse a bien été pris en compte.</B><br><br>";
                        echo ("</div>");
                    }
                }
            }
        }
    }
    echo ('</div>');
    echo ('</div>');
}

//permet de modifier l'identifiant de la session
if (isset($_POST["newLogin"])) {
    if ($data = json_decode(file_get_contents('../data/login.json'), true)) {
        foreach ($data['registered'] as $key => &$registered) {
            if ($registered['login'] == $_SESSION['login']) {
                $registered['login'] = $_POST['newLogin'];
                $_SESSION['login'] = $_POST['newLogin'];
            }
        }
        file_put_contents('../data/login.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}

//permet de modifier le mot de passe de la session
if (isset($_POST["oldPassword"])) {
    if (!password_verify($_POST["oldPassword"], $_SESSION["password"])) {
        echo "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, votre ancien mot de passe ne correspond pas, veuillez réessayer. </h4></div>";
        exit();
    } elseif ($_POST["newPassword"] != $_POST["confirmNewPassword"]) {
        echo "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le nouveau mot de passe et sa confirmation ne correspondent pas, veuillez réessayer. </h4></div>";
        exit();
    } else {
        if ($data = json_decode(file_get_contents('../data/login.json'), true)) {
            foreach ($data['registered'] as $key => &$registered) {
                if ($registered['login'] == $_SESSION['login']) {
                    $registered['password'] = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                    $_SESSION["password"] = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                }
            }
            file_put_contents('../data/login.json', json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}

//permet de modifier le numéro de téléphone de l'assuré
if (isset($_POST['newPhoneNumber'])) {
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => &$insured) {
            if ($insured['name'] == $_SESSION['name'] && $insured['fname'] == $_SESSION['fname']) {
                $insured['phoneNumber'] = $_POST['newPhoneNumber'];
            }
        }
        file_put_contents('../data/insured.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}

//permet de modifier le mail de l'assuré
if (isset($_POST['newMail'])) {
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => &$insured) {
            if ($insured['name'] == $_SESSION['name'] && $insured['fname'] == $_SESSION['fname']) {
                $insured['mail'] = $_POST['newMail'];
            }
        }
        file_put_contents('../data/insured.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}

//permet de faire la demande pour un changement d'adresse.
if (isset($_POST['newAdress'])) {
    if (file_exists($_SESSION["name"] . $_SESSION["fname"] . '.png')) {
        unlink($_SESSION["name"] . $_SESSION["fname"] . '.png');
    } else if (file_exists($_SESSION["name"] . $_SESSION["fname"] . '.jpg')) {
        unlink($_SESSION["name"] . $_SESSION["fname"] . '.jpg');
    } else if (file_exists($_SESSION["name"] . $_SESSION["fname"] . '.pdf')) {
        unlink($_SESSION["name"] . $_SESSION["fname"] . '.pdf');
    } else if (file_exists($_SESSION["name"] . $_SESSION["fname"] . '.jpeg')) {
        unlink($_SESSION["name"] . $_SESSION["fname"] . '.jpeg');
    }
    if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
        foreach ($data['insured'] as $key => $insured) {
            $cars = $insured['car'];
            foreach ($cars as $key => $car) {
                $newChangeCoord = array(
                    "insuredName" => $_SESSION["name"],
                    "insuredFname" => $_SESSION["fname"],
                    "insurance" => $car['greenCard']['insurerInfo']['name'],
                    "newAdress" => $_POST["newAdress"],
                    "newCity" => $_POST["newCity"],
                    "newPostal" => $_POST["newPostalCode"],
                    "newCountry" => $_POST["newCountry"],
                );
            }
        }
    }
    if ($myJson = json_decode(file_get_contents('../data/changeCoord.json'), true)) {
        foreach ($myJson['changeCoord'] as $key => &$newCoord) {
            if ($newCoord["insuredName"] == $_SESSION['name'] && $newCoord['insuredFname'] == $_SESSION['fname']) {
                unset($myJson['changeCoord'][$key]);
            }
        }
        array_push($myJson['changeCoord'], $newChangeCoord);
        file_put_contents('../data/changeCoord.json', json_encode($myJson, JSON_PRETTY_PRINT));
    }
    switch ($_FILES["proofAdress"]["type"]) {
        case "image/png":
            $path = '../data/proofsAdress/' . $_SESSION["name"] . $_SESSION["fname"] . '.png';
            move_uploaded_file($_FILES["proofAdress"]["tmp_name"], $path);
            break;

        case "image/jpg":
            $path = '../data/proofsAdress/' . $_SESSION["name"] . $_SESSION["fname"] . '.jpg';
            move_uploaded_file($_FILES["proofAdress"]["tmp_name"], $path);
            break;

        case "image/jpeg":
            $path = '../data/proofsAdress/' . $_SESSION["name"] . $_SESSION["fname"] . '.jpeg';
            move_uploaded_file($_FILES["proofAdress"]["tmp_name"], $path);
            break;

        case "application/pdf":
            $path = '../data/proofsAdress/' . $_SESSION["name"] . $_SESSION["fname"] . '.pdf';
            move_uploaded_file($_FILES["proofAdress"]["tmp_name"], $path);
            break;

        default:
            echo "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le fichier saisi n'est pas valide. </h4></div>";
            break;
    }
}
?>