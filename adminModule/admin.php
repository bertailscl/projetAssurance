<?php
    session_start();
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'admin':
                if (!isset($_POST['newInsurance']) && !isset($_POST['sendNewInsurance']) && !isset($_POST['newManager']) && !isset($_POST['sendNewManager'])) {
                    header('Location: ../adminModule/adminHome.php');
                    exit();
                }
                break;
            
            case 'insured':
                header('Location: insuredHome.php');
                exit(); 
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
    }else {
        session_unset();
        header('Location: ../visitorModule/connection.php');
        exit();
    }

    //ajouter une nouvelle assurance
    if (isset($_POST['newInsurance'])) {
        echo ('
            <label class="text-light" for="name">Name : </label><input id="name" name="name" type="text" placeholder="Nom de l\'assurance"><br>
            <label class="text-light" for="adress">Adresse : </label><input id="adress" name="adress" type="text" placeholder="Adresse"><br>
            <label class="text-light" for="city">Ville : </label><input id="city" name="city" type="text" placeholder="Ville"><br>
            <label class="text-light" for="postalCode">Code postal : </label><input id="postalCode" name="postalCode" type="text" placeholder="Code postal"><br>
            <label class="text-light" for="country">Pays : </label><input id="country" name="country" type="text" placeholder="Pays"><br>
            <label class="text-light" for="phoneNumber">Tel : </label><input id="phoneNumber" name="phoneNumber" type="text" placeholder="Téléphone"><br>
            <label class="text-light" for="countryCode">Code pays : </label><input id="countryCode" name="countryCode" type="text" placeholder="Code pays"><br>
            <label class="text-light" for="insurerCode">Code assureur : </label><input id="insurerCode" name="insurerCode" type="text" placeholder="Code assureur"><br>
            <input type="button" name="sendNewInsurance" value="Valider" onclick="sendNewInsurance()">
        ');
    }
    //envoyer les données de la nouvelle assurance
    if (isset($_POST['sendNewInsurance'])) {
        $newInsurance =array(
            "name"=> $_POST['name'],
            "adress"=> $_POST['adress'],
            "city"=> $_POST['city'],
            "postalCode"=> $_POST['postalCode'],
            "country"=> $_POST['country'],
            "phoneNumber"=> $_POST['phoneNumber'],
            "countryCode"=> $_POST['countryCode'],
            "insurerCode"=> $_POST['insurerCode'],
            "countriesValidity"=> array(
                "A",
                "B",
                "BG",
                "CY",
                "CZ",
                "D",
                "DK",
                "E",
                "EST",
                "F",
                "FIN",
                "GB",
                "GR",
                "H",
                "I",
                "IRL",
                "IS",
                "L",
                "LT",
                "LV",
                "M",
                "N",
                "NL",
                "P",
                "PL",
                "RO",
                "S",
                "SK",
                "SLO",
                "CH",
                "AL",
                "'AND'",
                "BIH",
                "BY",
                "HR",
                "IL",
                "IR",
                "MA",
                "MD",
                "MK",
                "RUS",
                "SRB",
                "TN",
                "TR",
                "UA"
            )
        );
        if ($myJson = json_decode(file_get_contents('../data/insurance.json'),true)) {
            array_push($myJson['insurance'], $newInsurance);
            file_put_contents('../data/insurance.json', json_encode($myJson, JSON_PRETTY_PRINT));
        }
    echo "<div class='text-light'>";
        echo "<p>L'assureur a bien été ajouté.</p>";
    echo "</div>";
    }

    //ajouter un nouveau manager
    if (isset($_POST['newManager'])) {
        echo ('
            <label class="text-light" for="fname">Name : </label><input id="fname" name="fname" type="text" placeholder="Nom"><br>
            <label class="text-light" for="name">Prénom : </label><input id="name" name="name" type="text" placeholder="Prénom"><br>
            <label class="text-light" for="insurance">Assurance : </label><input id="insurance" name="insurance" type="text" placeholder="Assurance"><br>
            <input type="button" name="sendNewManager" value="Valider" onclick="sendNewManager()">
        ');
    }

    //envoyer les données du nouveau manager
    if (isset($_POST['sendNewManager'])) {
        if ($data = json_decode(file_get_contents('../data/insurance.json'),true)) {
            foreach($data['insurance'] as $key => $insurance){
                if ($_POST['insurance'] == $insurance['name']) {
                    $newRegisterd =array(
                        "login" => $_POST['name'].$_POST['fname'],
                        "password" => password_hash($_POST['name'].$_POST['fname'], PASSWORD_DEFAULT),
                        "profile" => "manager",
                        "company"=> $_POST['insurance']
                    );
                    if ($myJson = json_decode(file_get_contents('../data/login.json'),true)) {
                        array_push($myJson['registered'], $newRegisterd);
                        file_put_contents('../data/login.json', json_encode($myJson, JSON_PRETTY_PRINT));
                    }
                }
            }
        }
    echo "<div class='text-light'>";
        echo "<p>Le compte a bien été créer.</p>";
    echo "</div>";
    }
?>