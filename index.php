<?php

require_once('configurations/Database.php');
require_once('configurations/send_json.php');
require_once('models/forAdmin/company.php');
require_once('models/forAdmin/administrator.php');
require_once('models/forAdmin/department.php');
require_once('models/forAdmin/grade.php');
require_once("controllers/forAdmin/admin_login.php");
require_once("controllers/forAdmin/get_all_companies.php");
require_once("controllers/forAdmin/create_company.php");
require_once("controllers/forAdmin/delete_company.php");
require_once("controllers/forAdmin/admin_login.php");
require_once("controllers/forAdmin/update_company.php");
require_once("controllers/forAdmin/create_grade.php");
require_once("controllers/forAdmin/delete_grade.php");
require_once("controllers/forAdmin/create_department.php");
require_once("controllers/forAdmin/delete_department.php");
 



try {
    if (!empty($_GET['demande'])) {
        $url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case "loginAsAdmin":

                loginAsAdmin();
                break;
            case "newCompany":
                newCompany();

                break;

            case "allCompanies":

                allCompanies();
                break;

            case "deleteCompany":

                deleteCompany();
                break;

            case "updateCompany":

                updateCompany();

                break;
            case "newGrade":
                newGrade();
                break;
            case "deleteGrade":
                deleteGrade();

                break;

            case "newDepartment":
                newDepartment();

                break;
            case "deleteDepartment":

                deleteDepartment();
                break;



            default:
                throw new Exception("La demande n'est pas valide, vérifiez l'url");
        }

    } else {
        include_once("views/home.php");
    }
} catch (Exception $e) {
     echo $e->getMessage();
}
?>