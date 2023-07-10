<?php
class User
{
   
    private $connexion = null;
    public $companyName;
    public $emailAdd;
    public $username;
    public $department;
    public $grade;
    public $password;
    public $maxAmount;

    public function __construct($databases)
    {

        if ($this->connexion == null) {
            $this->connexion = $databases;
        }

    }

    public function signup()
    {

      

        try {
            // Vérifier si la table existe déjà
            $tableName = 'WORKFLOWUSERS';
            $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
            $stmt = $this->connexion->query($checkTableQuery);
            $tableExists = $stmt->rowCount() > 0;

            if (!$tableExists) {
                // Créer la table workflowusers si elle n'existe pas
                $createTableQuery = "CREATE TABLE $tableName (
                COMPANYID VARCHAR(255),
                EMAILADD VARCHAR(255) UNIQUE,
                USERNAME VARCHAR(255),
                DEPARTMENT VARCHAR(255),
                GRADE VARCHAR(255),
                PASSWORD VARCHAR(255),
                MAXAMOUNT VARCHAR(255)
            )";
                if ($this->connexion->exec($createTableQuery) == false) {

                    return false;
                }
            }

            // Insérer les informations dans la table workflowusers
            $insertQuery = "INSERT INTO $tableName (COMPANYID, EMAILADD, USERNAME, DEPARTMENT, GRADE, PASSWORD, MAXAMOUNT)
                        VALUES (:companyId, :emailAdd, :username, :department, :grade, :password, :maxAmount)";
            $stmt = $this->connexion->prepare($insertQuery);
            $stmt->bindParam(':companyId', $this->companyName);
            $stmt->bindParam(':emailAdd', $this->emailAdd);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':department', $this->department);
            $stmt->bindParam(':grade', $this->grade);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':maxAmount', $this->maxAmount);

            if ($stmt->execute()) {
                return true;

            } else {
                return false;

            }


        } catch (PDOException $e) {
            return false;
        }


    }

}








?>