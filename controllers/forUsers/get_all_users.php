<?php

function companyAllUsers()
{
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset= UTF-8");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $databases = new Database();



        $inputData = json_decode(file_get_contents("php://input"));

        if (!empty($inputData->companyName)) {
            $connexion = $databases->connectToCompanyDB($inputData->companyName);
            $userInstance = new User($connexion);


            $userInstance->companyName = htmlspecialchars($inputData->companyName);
            $users = $userInstance->getAllUsers();
            sendJSON($users);
        } else {
            sendJSON(array("message" => "Veuillez renseigner correctement le nom de la compagnie (companyName)"));
        }

    } else {

        sendJSON(array("message" => "La methode n'est pas autorisée"));
    }

}











?>
 




