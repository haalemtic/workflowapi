<?php
 
class Database
{


    //Workflow Database credentials
    private  $host = "www.vbs-solutions.com";
    private  $dbname = "u833159023_workflow_admin";
    private  $username = "u833159023_kinda";
    private  $password = "Kind@1404";


    public function connectToWorkflowDB()
    {

        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            echo "Erreur de connexion : " . $e->getMessage();
        }

        return $pdo;
    }

}








?>