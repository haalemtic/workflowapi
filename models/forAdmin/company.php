<?php

class Company
{

    private $table = "Company";
    private $connexion = null;
    public $id;
    public $backgroundColor;
    public $companyName;
    public $username;
    public $databaseName;
    public $password;
    public $servername;

    public function __construct($databases)
    {
        if ($this->connexion == null) {
            $this->connexion = $databases;
        }
    }

    public function getAllCompanies()
    {

        // Requête pour récupérer toutes les entreprises
        $queryCompanyBase = "SELECT * FROM $this->table";
        $statementCompanyBase = $this->connexion->query($queryCompanyBase);
        $companiesBase = $statementCompanyBase->fetchAll(PDO::FETCH_ASSOC);

        // Requête pour récupérer toutes les grades
        $queryGrade = "SELECT * FROM Grade";
        $statementGrade = $this->connexion->query($queryGrade);
        $grades = $statementGrade->fetchAll(PDO::FETCH_ASSOC);

        // Requête pour récupérer toutes les départements
        $queryDepartment = "SELECT * FROM Department";
        $statementDepartment = $this->connexion->query($queryDepartment);
        $departments = $statementDepartment->fetchAll(PDO::FETCH_ASSOC);

        $companies = array();


        foreach ($companiesBase as $company) {
            $companyId = $company['id'];
            $company['status'] = null;
            $company['grades'] = array();
            $company['departments'] = array();




            foreach ($grades as $grade) {
                if ($grade['companyId'] === $companyId) {
                    $company['grades'][] = $grade;
                }
            }

            foreach ($departments as $department) {
                if ($department['companyId'] === $companyId) {
                    $company['departments'][] = $department;
                }
            }



            $companyStatus = $this->getCompanyStatus($company);

            $company['status'] = $companyStatus;







            $companies[] = $company;




        }





        return $companies;


    }




    public function createCompany()
    {



        try {
         
            $query = "INSERT INTO $this->table (backgroundColor, companyName, username, databaseName, password, servername)
                          VALUES (:backgroundColor, :companyName, :username, :databaseName, :password, :servername)";
            $statement = $this->connexion->prepare($query);

            $statement->bindParam(':backgroundColor', $this->backgroundColor);
            $statement->bindParam(':companyName', $this->companyName);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':databaseName', $this->databaseName);
            $statement->bindParam(':password', $this->password);
            $statement->bindParam(':servername', $this->servername);
            $exec = $statement->execute();

            return $exec;
        } catch (PDOException $e) {
            return false;
        }

    }



    public function updateCompany()
    {
       
          try{
              // Requête pour mettre à jour la compagnie
              $query = "UPDATE $this->table SET companyName = :companyName, databaseName = :database, servername = :servername, username = :username, password = :password WHERE id = :companyId";

              // Préparation de la requête
              $statement = $this->connexion->prepare($query);
              $statement->bindParam(':database', $this->databaseName);
              $statement->bindParam(':servername', $this->servername);
              $statement->bindParam(':username', $this->username);
              $statement->bindParam(':password', $this->password);
              $statement->bindParam(':companyId', $this->id);
              $statement->bindParam(':companyName', $this->companyName);
  
              $exec = $statement->execute();
  
              return $exec;
          } catch(PDOException){
            return false;
          }


        
    }


    public function deleteCompany()
    {
       
    
        try {
          
    
            // Désactiver les contraintes de clé étrangère temporairement
            $this->connexion->exec("SET FOREIGN_KEY_CHECKS = 0");
    
            // Supprimer les enregistrements de la table Department liés à la compagnie
            $deleteDepartmentsQuery = "DELETE FROM Department WHERE companyId = :companyId";
            $deleteDepartmentsStmt =$this->connexion->prepare($deleteDepartmentsQuery);
            $deleteDepartmentsStmt->bindParam(':companyId', $this->id);
            $deleteDepartmentsStmt->execute();
    
            // Supprimer la compagnie de la table Company
            $deleteCompanyQuery = "DELETE FROM Company WHERE id = :companyId";
            $deleteCompanyStmt = $this->connexion->prepare($deleteCompanyQuery);
            $deleteCompanyStmt->bindParam(':companyId', $this->id);
            $exec= $deleteCompanyStmt->execute();
    
            // Réactiver les contraintes de clé étrangère
            $this->connexion->exec("SET FOREIGN_KEY_CHECKS = 1");


            return $exec;
    
             
        } catch (PDOException $e) {
            // Une erreur s'est produite lors de la suppression
            return false;
        }
    }
    private function getCompanyStatus($company)
    {
        $servername = $company['servername'];
        $database = $company['databaseName'];
        $username = $company['username'];
        $password = $company['password'];

     
            // Tentative de connexion à la base de données de l'entreprise
            if ($servername != "vbs-solutions.com") {
                $pdo = new PDO("sqlsrv:Server=$servername;Database=$database", '', '');
            } else {
                $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            }

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fermer la connexion
            $pdo = null;

            return true;
        
    }

}

















?>