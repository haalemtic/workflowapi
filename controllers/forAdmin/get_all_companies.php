<?php








function allCompanies()
{
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset= UTF-8");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $databases = new Database();
        $connexion = $databases->connectToWorkflowDB();
        $companyInstance = new Company($connexion);
        $companies = $companyInstance->getAllCompanies();


        sendJSON($companies);




    } else {

        sendJSON(array("message" => "La methode n'est pas autorisée"));
    }

}











?>