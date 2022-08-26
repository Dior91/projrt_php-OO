<?php

require_once "database.php";

class MainModel
{
    // une proriété protected ne peut etre accessible que par les classes enfant (extends)
    protected $pdo;
    
    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connection();
    }

    protected function redirect($page = "index.php")
  {
     // On redirige vers la page d'accueil
     header("Location: $page");
     exit;
  }
}