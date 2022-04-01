<?php

include '../data/heapSort.php';
    session_start();
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'manager':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;
            
            case 'admin':
                if (!isset($_POST['mail']) && !isset($_POST['printMail']) && !isset($_POST['writeMail']) && !isset($_POST['choseReceiver']) && !isset($_POST['sendMessage'])) {
                    header('Location: insuredHome.php');
                    exit(); 
                }
                break;

            case 'police':
                header('Location: ../policeModule/policeHome.php');
                exit();
                break;
            
            case 'insured':
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
    //afficher les bouttons de mail
    if (isset($_POST['mail'])) {
        echo ('<br><input type="button" onclick="readMail()" name="button" value="Lire les messages">
        <input type="button" onclick="writeMail()" name="button" value="Envoyer un message">');
    }
    //afficher la boite mail
    if (isset($_POST['printMail'])) {
        $allMessagesToAdmin = array();
        if ($data = json_decode(file_get_contents('../data/insuredMail.json'),true)) {
            foreach($data['insuredMessages'] as $key => $message){
                if ($message["receiver"] == "admin") {
                    array_push($allMessagesToAdmin, $message);
                }
            }
        }
        if ($data = json_decode(file_get_contents('../data/insuranceMail.json'),true)) {
            foreach($data['insuranceMessages'] as $key => $message){
                if ($message["receiver"] == "admin") {
                    array_push($allMessagesToAdmin, $message);
                }
            }
        }
        //trier le tableau par date d'envoi (du plus récent au plus ancien)
        if (sizeof($allMessagesToAdmin) != 0) {
            $Heap = new Heap();
            foreach ($allMessagesToAdmin as $key => $message) {
                $Node = new Node($message['mailDate']);
                $Heap->insertAt($key, $Node);
                $Heap->incrementSize();
            }
            $sortedDates = array_reverse(heapsort($Heap));
            $allMessagesToAdminTmp = array();
            foreach($sortedDates as $key => $date){
                foreach($allMessagesToAdmin as $key => $message){
                    if ($message['mailDate'] == $date) {
                        array_push($allMessagesToAdminTmp, $message);
                    }
                }
            }
            $allMessagesToAdmin = $allMessagesToAdminTmp;
            foreach($allMessagesToAdmin as $key => $message){
                echo "<div>";
                    if (isset($message['insuredName'])) {
                        echo "De : ".$message['insuredName'].$message['insuredFname'];
                    } else {
                        echo "De : ".$message['insurance'];
                    }
                    echo " | ".$message['object'];
                    echo (' <input class="button" type="button" name="readMessage" value="Lire" onclick="readMessage('.$key.')"><br>');
                    echo "<div id='".$key."' style='display:none'>";
                        echo '<p>'.$message["content"].'</p>';
                echo "</div>";
                echo "</div>";
            }
        }
    }

    //rédiger un mail
    if (isset($_POST['writeMail'])) {
        echo "<div class='text-light'>";
        echo "<label for='receiver'>Choisissez un destinataire : </label>";
        echo '<select id="receiver" name="receiver" required>';
        echo "<option value='' disabled selected hidden>Mes destinataires</option>";
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    echo "<option id='".$car['greyCard']['A']."' value='".$car['greyCard']['A']."'>".$insured['name']." ".$insured['fname']."</option>";
                }
            }
        }
        if ($data = json_decode(file_get_contents('../data/insurance.json'),true)) {
            foreach($data['insurance'] as $key => $insurance){
                echo "<option id='".$insurance['name']."'>".$insurance['name']."</option>";
            }
        }
        // echo "<option id='admin' value='admin'>Administrateur</option>";
        echo ('</select><br><br>');
        echo "<label for='mailObject'>Objet : </label>";
        echo '<input id="mailObject" name="mailObject" type="text" placeHolder="Entrez le sujet du message." required><br><br>';
        echo "<label for='mailObject'>Message : </label>";
        echo '<input id="mailContent" name="mailContent" type="text" placeHolder="Entre le contenu de votre message ici." required><br><br>';
        echo ('<input class="button" type="button" name="sendMessage" value="Envoyer" onclick="sendMessage()"><br><br>');
        echo "</div>";
    }

    //permet d'enregistrer le mail
    if (isset($_POST['sendMessage'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($_POST['receiver'] == $car['greyCard']['A']) {
                        $newMessage = array(
                            "receiver" => 'insured',
                            "insuredName" => $insured["name"],
                            "insuredFname" => $insured["fname"],
                            "messageType" => "mail",
                            "mailDate" => $_POST['mailDate'],
                            "object" => $_POST["mailObject"],
                            "content" => $_POST["mailContent"]
                        );
                    }
                }
            }
        }
        if ($data = json_decode(file_get_contents('../data/insurance.json'),true)) {
            foreach($data['insurance'] as $key => $insurance){
                if ($_POST['receiver'] == $insurance['name']) {
                    $newMessage = array(
                        "receiver" => 'insurance',
                        "insurance" => $insurance['name'],
                        "messageType" => "mail",
                        "mailDate" => $_POST['mailDate'],
                        "object" => $_POST["mailObject"],
                        "content" => $_POST["mailContent"]
                    );
                }
            }
        }
        if ($myJson = json_decode(file_get_contents('../data/adminMail.json'),true)) {
            array_push($myJson['adminMessages'], $newMessage);
            file_put_contents('../data/adminMail.json', json_encode($myJson, JSON_PRETTY_PRINT));
        }
    echo "<div class='text-light'>";
        echo 'Le message a bien été envoyé.';
    echo "</div>";
    }
?>