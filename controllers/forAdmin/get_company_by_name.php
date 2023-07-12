<?php

function getCompanyByName()
{
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset= UTF-8");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $databases = new Database();
        $connexion = $databases->connectToWorkflowDB();
        $companyInstance = new Company($connexion);
        $inputData = json_decode(file_get_contents("php://input"));

        if (!empty($inputData->companyName)) {
            $companyInstance->companyName = htmlspecialchars($inputData->companyName);
            $companies = $companyInstance->getCompanyByName();
            sendJSON($companies);
        } else {
            sendJSON(array("message" => "Veuillez renseigner correctement le nom de la compagnie (companyName)"));
        }





    } else {

        sendJSON(array("message" => "La methode n'est pas autorisée"));
    }

}











?>