<?php
    include('../qrcode/QR_BarCode.php');
    include('../data/heapSort.php');
    session_start();
    //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'admin':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;
            
            case 'insured':
                header('Location: ../insuredModule/insuredHome.php');
                exit();
                break;

            case 'police':
                header('Location: ../policeModule/policeHome.php');
                exit();
                break;
            
            case 'manager':
                if (!isset($_POST['form'])){
                    header('Location: managerHome.php');
                    exit(); 
                }
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

    //permet de generer le numéro de contrat
    function generateContractNumber(){
        $contract = array();
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    array_push($contract, $car["greenCard"]['codes']['contractNumber']);
                    echo($contract);
                }
            }
        }
        if (isset($contract[0])) {
            $Heap = new Heap();
            foreach ($contract as $key => $contractNumber) {
                $Node = new Node($contractNumber);
                $Heap->insertAt($key, $Node);
                $Heap->incrementSize();
            }
            $contract = array_reverse(heapsort($Heap));
            return $contract[0]+1;
        } else {
            return "1";
        }
    }

    //enregistrer les informations du nouveau contrat
    if (isset($_POST['form'])) {
        $continue = true;
        if ($data = json_decode(file_get_contents('../data/insurance.json'),true)) {
            foreach($data['insurance'] as $key => $insurance){
                if($insurance['name'] == $_SESSION['company']){
                    if ($data2 = json_decode(file_get_contents('../data/insured.json'),true)) {
                        foreach($data2['insured'] as $key => $insured){
                            if (isset($insured['car'])) {
                                $cars = $insured['car'];
                                if ($insured['name'] == $_POST['name'] && $insured['fname'] == $_POST['fname']){
                                    foreach($cars as $key => $car) {
                                        if ($car['greyCard']['A'] == $_POST['A']){
                                            $continue = false;
                                        }
                                    }
                                    if ($continue) {
                                        foreach($cars as $key => $car) {
                                            $contract = generateContractNumber();
                                            $newContract =array(
                                                "greyCard" => array(
                                                    "A" => $_POST['A'],
                                                    "B" => $_POST['B'],
                                                    "C_1_name" => $_POST['C_1_name'],
                                                    "C_1_fname" => $_POST['C_1_fname'],
                                                    "C_3_adress" => $_POST['C_3_adress'],
                                                    "C_3_postal" => $_POST['C_3_postal'],
                                                    "C_3_city" => $_POST['C_1_name'],
                                                    "C_3_country" => $_POST['C_3_country'],
                                                    "D_1" => $_POST['D_1'],
                                                    "D_2" => $_POST['D_2'],
                                                    "D_2_1" => $_POST['D_2_1'],
                                                    "D_3" => $_POST['D_3'],
                                                    "E" => $_POST['E'],
                                                    "F_1" => $_POST['F_1'],
                                                    "F_2" => $_POST['F_2'],
                                                    "F_3" => $_POST['F_3'],
                                                    "G" => $_POST['G'],
                                                    "G_1" => $_POST['G_1'],
                                                    "J" => $_POST['J'],
                                                    "J_1" => $_POST['J_1'],
                                                    "J_2" => $_POST['J_2'],
                                                    "J_3" => $_POST['J_3'],
                                                    "K" => $_POST['K'],
                                                    "P_1" => $_POST['P_1'],
                                                    "P_2" => $_POST['P_2'],
                                                    "P_3" => $_POST['P_3'],
                                                    "P_6" => $_POST['P_6'],
                                                    "Q" => $_POST['G'],
                                                    "S_1" => $_POST['S_1'],
                                                    "S_2" => $_POST['S_2'],
                                                    "U_1" => $_POST['U_1'],
                                                    "U_2" => $_POST['U_2'],
                                                    "V_7" => $_POST['V_7'],
                                                    "V_9" => $_POST['V_9'],
                                                    "X_1" => "VISITE AVANT LE ".$_POST['X_1'],
                                                    "Y_1" => $_POST['Y_1'],
                                                    "Y_2" => $_POST['Y_2'],
                                                    "Y_3" => $_POST['Y_3'],
                                                    "Y_4" => $_POST['Y_4'],
                                                    "Y_5" => $_POST['Y_5'],
                                                    "Y_6" => $_POST['Y_6'],
                                                    "H" => $_POST['H'],
                                                    "I" => $_POST['I'],
                                                    "Z_1" => $_POST['Z_1'],
                                                    "Z_2" => $_POST['Z_2'],
                                                    "Z_3" => $_POST['Z_3'],
                                                    "Z_4" => $_POST['Z_4'],
                                                    "certificat" => array(
                                                        "immatriculation" => $_POST['A'],
                                                        "immatriculationDate" => $_POST['I'],
                                                        "code" => $_POST['code'],
                                                        "cnit" => $_POST['E'],
                                                        "brand" => $_POST['D_1'],
                                                        "fname" => $_POST['C_1_fname'],
                                                        "name" => $_POST['C_1_name']
                                                    )
                                                ),
                                                "greenCard" => array(
                                                    "validityStart" => $_POST['validityStart'],
                                                    "validityEnd" => $_POST['validityEnd'],
                                                    "namesAndAdress" => array(
                                                        "countryCode" => $insurance['countryCode'],
                                                        "insurerCode" => $insurance['insurerCode'],
                                                        "contractNumber" => $contract
                                                    ),
                                                    "immatriculation" => $_POST['A'],
                                                    "vehicleCategory" => $_POST['vehicleType'],
                                                    "model" => $_POST['D_1'],
                                                    "countriesValidity" => $insurance['countriesValidity'],
                                                    "namesAndAdress" => array(
                                                        "name" => $_POST['1stConductorFname'],
                                                        "fname" => $_POST['1stConductorName'],
                                                        "adress" => $_POST['1stConductorAdress'],
                                                        "city" => $_POST['1stConductorCity'],
                                                        "postalCode" => $_POST['1stConductorPostalCode'],
                                                        "country" => $_POST['1stConductorCountry']
                                                    ),
                                                    "insurerInfo" => array(
                                                        "name" => $insurance['name'],
                                                        "adress"=> $insurance['adress'],
                                                        "city" => $insurance['city'],
                                                        "postalCode" => $insurance['postalCode'],
                                                        "country" => $insurance['country'],
                                                        "phoneNumber" => $insurance['phoneNumber']
                                                    )
                                                )
                                            );
                                            if ($myJson = json_decode(file_get_contents('../data/insured.json'),true)) {
                                                array_push($myJson['insured'], $newInsured);
                                                file_put_contents('../data/insured.json', json_encode($myJson, JSON_PRETTY_PRINT));
                                            }
                                            echo "<p>Le contrat a bien été créer.</p>";
                                            $qr = new QR_BarCode();
                                            $qr->url('http://localhost/projetAssurance/visitorModule/visitorHome.php?immatriculation='.$_POST["A"].'&contrat='.$contrat);
                                            $qr->qrCode(400, '../data/qrCodes/'.$_POST['A'].'.png');
                                            echo("<img src='../data/qrCodes/".$_POST['A'].".png''>");
                                            exit();
                                        }
                                    } else {
                                        echo "<p>Il existe déja un contrat pour cette voiture.</p>";
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($data = json_decode(file_get_contents('../data/insurance.json'),true)) {
            foreach($data['insurance'] as $key => $insurance){
                if($insurance['name'] == $_SESSION['company']){
                    if ($data2 = json_decode(file_get_contents('../data/insured.json'),true)) {
                        if (isset($data2['insured']['name'])) {
                            foreach($data2['insured'] as $key => $insured){
                                if ($insured['name'] != $_POST['name'] && $insured['fname'] != $_POST['fname'] && $continue) {
                                    $contract = generateContractNumber();
                                    $newInsured =array(
                                        "name" => $_POST['name'],
                                        "fname" => $_POST['fname'],
                                        "phoneNumber" => $_POST['phoneNumber'],
                                        "mail" => $_POST['mail'],
                                        "adress" => $_POST['adress'],
                                        "city" => $_POST['city'],
                                        "postalCode" => $_POST['postalCode'],
                                        "country" => $_POST['country'],
                                        "car" => array( 
                                            array(
                                                "greyCard" => array(
                                                    "A" => $_POST['A'],
                                                    "B" => $_POST['B'],
                                                    "C_1_name" => $_POST['C_1_name'],
                                                    "C_1_fname" => $_POST['C_1_fname'],
                                                    "C_3_adress" => $_POST['C_3_adress'],
                                                    "C_3_postal" => $_POST['C_3_postal'],
                                                    "C_3_city" => $_POST['C_1_name'],
                                                    "C_3_country" => $_POST['C_3_country'],
                                                    "D_1" => $_POST['D_1'],
                                                    "D_2" => $_POST['D_2'],
                                                    "D_2_1" => $_POST['D_2_1'],
                                                    "D_3" => $_POST['D_3'],
                                                    "E" => $_POST['E'],
                                                    "F_1" => $_POST['F_1'],
                                                    "F_2" => $_POST['F_2'],
                                                    "F_3" => $_POST['F_3'],
                                                    "G" => $_POST['G'],
                                                    "G_1" => $_POST['G_1'],
                                                    "J" => $_POST['J'],
                                                    "J_1" => $_POST['J_1'],
                                                    "J_2" => $_POST['J_2'],
                                                    "J_3" => $_POST['J_3'],
                                                    "K" => $_POST['K'],
                                                    "P_1" => $_POST['P_1'],
                                                    "P_2" => $_POST['P_2'],
                                                    "P_3" => $_POST['P_3'],
                                                    "P_6" => $_POST['P_6'],
                                                    "Q" => $_POST['G'],
                                                    "S_1" => $_POST['S_1'],
                                                    "S_2" => $_POST['S_2'],
                                                    "U_1" => $_POST['U_1'],
                                                    "U_2" => $_POST['U_2'],
                                                    "V_7" => $_POST['V_7'],
                                                    "V_9" => $_POST['V_9'],
                                                    "X_1" => "VISITE AVANT LE ".$_POST['X_1'],
                                                    "Y_1" => $_POST['Y_1'],
                                                    "Y_2" => $_POST['Y_2'],
                                                    "Y_3" => $_POST['Y_3'],
                                                    "Y_4" => $_POST['Y_4'],
                                                    "Y_5" => $_POST['Y_5'],
                                                    "Y_6" => $_POST['Y_6'],
                                                    "H" => $_POST['H'],
                                                    "I" => $_POST['I'],
                                                    "Z_1" => $_POST['Z_1'],
                                                    "Z_2" => $_POST['Z_2'],
                                                    "Z_3" => $_POST['Z_3'],
                                                    "Z_4" => $_POST['Z_4'],
                                                    "certificat" => array(
                                                        "immatriculation" => $_POST['A'],
                                                        "immatriculationDate" => $_POST['I'],
                                                        "code" => $_POST['code'],
                                                        "cnit" => $_POST['E'],
                                                        "brand" => $_POST['D_1'],
                                                        "fname" => $_POST['C_1_fname'],
                                                        "name" => $_POST['C_1_name']
                                                    )
                                                ),
                                                "greenCard" => array(
                                                    "validityStart" => $_POST['validityStart'],
                                                    "validityEnd" => $_POST['validityEnd'],
                                                    "codes" => array(
                                                        "countryCode" => $insurance['countryCode'],
                                                        "insurerCode" => $insurance['insurerCode'],
                                                        "contractNumber" => $contract
                                                    ),
                                                    "immatriculation" => $_POST['A'],
                                                    "vehicleCategory" => $_POST['vehicleType'],
                                                    "model" => $_POST['D_1'],
                                                    "countriesValidity" => $insurance['countriesValidity'],
                                                    "namesAndAdress" => array(
                                                        "name" => $_POST['1stConductorFname'],
                                                        "fname" => $_POST['1stConductorName'],
                                                        "adress" => $_POST['1stConductorAdress'],
                                                        "city" => $_POST['1stConductorCity'],
                                                        "postalCode" => $_POST['1stConductorPostalCode'],
                                                        "country" => $_POST['1stConductorCountry']
                                                    ),
                                                    "insurerInfo" => array(
                                                        "name" => $insurance['name'],
                                                        "adress"=> $insurance['adress'],
                                                        "city" => $insurance['city'],
                                                        "postalCode" => $insurance['postalCode'],
                                                        "country" => $insurance['country'],
                                                        "phoneNumber" => $insurance['phoneNumber']
                                                    )
                                                )
                                            )
                                        )
                                    );
                                    if ($myJson = json_decode(file_get_contents('../data/insured.json'),true)) {
                                        array_push($myJson['insured'], $newInsured);
                                        file_put_contents('../data/insured.json', json_encode($myJson, JSON_PRETTY_PRINT));
                                    }
                                    echo "<p>Le contrat a bien été créer.</p>";
                                    $qr = new QR_BarCode();
                                    $qr->url('http://localhost/projetAssurance/visitorModule/visitorHome.php?immatriculation='.$_POST["A"].'&contrat='.$contract);
                                    $qr->qrCode(400, '../data/qrCodes/'.$_POST['A'].'.png');
                                    echo("<img src='../data/qrCodes/".$_POST['A'].".png''>");
                                    $newRegisterd =array(
                                        "login" => $_POST['name'].$_POST['fname'],
                                        "password" => password_hash($_POST['name'].$_POST['fname'], PASSWORD_DEFAULT),
                                        "profile" => "insured",
                                        "name" => $_POST['name'],
                                        "fname" => $_POST['fname']
                                    );
                                    if ($myJson = json_decode(file_get_contents('../data/login.json'),true)) {
                                        array_push($myJson['registered'], $newRegisterd);
                                        file_put_contents('../data/login.json', json_encode($myJson, JSON_PRETTY_PRINT));
                                    }
                                } 
                            }
                        } else {
                            $contract = generateContractNumber();
                            $newInsured =array(
                                "name" => $_POST['name'],
                                "fname" => $_POST['fname'],
                                "phoneNumber" => $_POST['phoneNumber'],
                                "mail" => $_POST['mail'],
                                "adress" => $_POST['adress'],
                                "city" => $_POST['city'],
                                "postalCode" => $_POST['postalCode'],
                                "country" => $_POST['country'],
                                "car" => array( 
                                    array(
                                        "greyCard" => array(
                                            "A" => $_POST['A'],
                                            "B" => $_POST['B'],
                                            "C_1_name" => $_POST['C_1_name'],
                                            "C_1_fname" => $_POST['C_1_fname'],
                                            "C_3_adress" => $_POST['C_3_adress'],
                                            "C_3_postal" => $_POST['C_3_postal'],
                                            "C_3_city" => $_POST['C_1_name'],
                                            "C_3_country" => $_POST['C_3_country'],
                                            "D_1" => $_POST['D_1'],
                                            "D_2" => $_POST['D_2'],
                                            "D_2_1" => $_POST['D_2_1'],
                                            "D_3" => $_POST['D_3'],
                                            "E" => $_POST['E'],
                                            "F_1" => $_POST['F_1'],
                                            "F_2" => $_POST['F_2'],
                                            "F_3" => $_POST['F_3'],
                                            "G" => $_POST['G'],
                                            "G_1" => $_POST['G_1'],
                                            "J" => $_POST['J'],
                                            "J_1" => $_POST['J_1'],
                                            "J_2" => $_POST['J_2'],
                                            "J_3" => $_POST['J_3'],
                                            "K" => $_POST['K'],
                                            "P_1" => $_POST['P_1'],
                                            "P_2" => $_POST['P_2'],
                                            "P_3" => $_POST['P_3'],
                                            "P_6" => $_POST['P_6'],
                                            "Q" => $_POST['G'],
                                            "S_1" => $_POST['S_1'],
                                            "S_2" => $_POST['S_2'],
                                            "U_1" => $_POST['U_1'],
                                            "U_2" => $_POST['U_2'],
                                            "V_7" => $_POST['V_7'],
                                            "V_9" => $_POST['V_9'],
                                            "X_1" => "VISITE AVANT LE ".$_POST['X_1'],
                                            "Y_1" => $_POST['Y_1'],
                                            "Y_2" => $_POST['Y_2'],
                                            "Y_3" => $_POST['Y_3'],
                                            "Y_4" => $_POST['Y_4'],
                                            "Y_5" => $_POST['Y_5'],
                                            "Y_6" => $_POST['Y_6'],
                                            "H" => $_POST['H'],
                                            "I" => $_POST['I'],
                                            "Z_1" => $_POST['Z_1'],
                                            "Z_2" => $_POST['Z_2'],
                                            "Z_3" => $_POST['Z_3'],
                                            "Z_4" => $_POST['Z_4'],
                                            "certificat" => array(
                                                "immatriculation" => $_POST['A'],
                                                "immatriculationDate" => $_POST['I'],
                                                "code" => $_POST['code'],
                                                "cnit" => $_POST['E'],
                                                "brand" => $_POST['D_1'],
                                                "fname" => $_POST['C_1_fname'],
                                                "name" => $_POST['C_1_name']
                                            )
                                        ),
                                        "greenCard" => array(
                                            "validityStart" => $_POST['validityStart'],
                                            "validityEnd" => $_POST['validityEnd'],
                                            "codes" => array(
                                                "countryCode" => $insurance['countryCode'],
                                                "insurerCode" => $insurance['insurerCode'],
                                                "contractNumber" => $contract
                                            ),
                                            "immatriculation" => $_POST['A'],
                                            "vehicleCategory" => $_POST['vehicleType'],
                                            "model" => $_POST['D_1'],
                                            "countriesValidity" => $insurance['countriesValidity'],
                                            "namesAndAdress" => array(
                                                "name" => $_POST['1stConductorFname'],
                                                "fname" => $_POST['1stConductorName'],
                                                "adress" => $_POST['1stConductorAdress'],
                                                "city" => $_POST['1stConductorCity'],
                                                "postalCode" => $_POST['1stConductorPostalCode'],
                                                "country" => $_POST['1stConductorCountry']
                                            ),
                                            "insurerInfo" => array(
                                                "name" => $insurance['name'],
                                                "adress"=> $insurance['adress'],
                                                "city" => $insurance['city'],
                                                "postalCode" => $insurance['postalCode'],
                                                "country" => $insurance['country'],
                                                "phoneNumber" => $insurance['phoneNumber']
                                            )
                                        )
                                    )
                                )
                            );
                            if ($myJson = json_decode(file_get_contents('../data/insured.json'),true)) {
                                array_push($myJson['insured'], $newInsured);
                                file_put_contents('../data/insured.json', json_encode($myJson, JSON_PRETTY_PRINT));
                            }
                            echo "<p>Le contrat a bien été créer.</p>";
                            $qr = new QR_BarCode();
                            $qr->url('http://localhost/projetAssurance/visitorModule/visitorHome.php?immatriculation='.$_POST["A"].'&contrat='.$contract);
                            $qr->qrCode(400, '../data/qrCodes/'.$_POST['A'].'.png');
                            echo("<img src='../data/qrCodes/".$_POST['A'].".png''>");
                            $newRegisterd =array(
                                "login" => $_POST['name'].$_POST['fname'],
                                "password" => password_hash($_POST['name'].$_POST['fname'], PASSWORD_DEFAULT),
                                "profile" => "insured",
                                "name" => $_POST['name'],
                                "fname" => $_POST['fname']
                            );
                            if ($myJson = json_decode(file_get_contents('../data/login.json'),true)) {
                                array_push($myJson['registered'], $newRegisterd);
                                file_put_contents('../data/login.json', json_encode($myJson, JSON_PRETTY_PRINT));
                            }
                        } 
                    }
                }
            }
        }
    }

?>