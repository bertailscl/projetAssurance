<?php
    //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    session_start();
    if (isset($_SESSION["profile"])) {
        switch ($_SESSION["profile"]) {
            case 'admin':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;

            case 'insured':
                if (!isset($_POST["myContracts"])) {
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

    if (isset($_POST['myContracts'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
            foreach ($data['insured'] as $key => &$insured) {
                $cars = $insured['car'];
                foreach ($cars as $key => &$car) {
                    if ($_POST['myContracts'] == $car['greyCard']['A']) {
                        $newSell = array(
                            "insuredName" => $_SESSION["name"],
                            "insuredFname" => $_SESSION["fname"],
                            "vehicle" => $_POST['myContracts'],
                            "insurance" => $car['greenCard']['insurerInfo']['name'],
                            "endValidity" => $_POST['endDate']
                        );
                        $car['greenCard']['validityEnd'] = $_POST['endDate'];
                    }
                }
                $insured['car'] = $cars;
            }
            file_put_contents('../data/insured.json', json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($myJson = json_decode(file_get_contents('../data/sellVehicle.json'),true)) {
            array_push($myJson['vehicle'], $newSell);
            file_put_contents('../data/sellVehicle.json', json_encode($myJson, JSON_PRETTY_PRINT));
        }
        $_FILES['proofSell'];
        switch ($_FILES["proofSell"]["type"]) {
            case "image/png":
                $path = '../data/proofsSell/'.$_POST["myContracts"].'.png';
                move_uploaded_file($_FILES["proofSell"]["tmp_name"], $path);
                break;

            case "image/jpg":
                $path = '../data/proofsSell/'.$_POST["myContracts"].'.jpg';
                move_uploaded_file($_FILES["proofSell"]["tmp_name"], $path);
                break;

            case "image/jpeg":
                $path = '../data/proofsSell/'.$_POST["myContracts"].'.jpeg';
                move_uploaded_file($_FILES["proofSell"]["tmp_name"], $path);
                break;

            case "application/pdf":
                $path = '../data/proofsSell/'.$_POST["myContracts"].'.pdf';
                move_uploaded_file($_FILES["proofSell"]["tmp_name"], $path);
                break;

            default:
                echo "Erreur, le fichier saisi n'est pas valide.";
                break;
        }
    }
?>