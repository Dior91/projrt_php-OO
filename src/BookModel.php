<?php
require_once "Book.php";
require_once "MainModel.php";

class BookModel extends MainModel
{

  // Nous utilisons des méthodes "static" lorsqu'il est inutile d'instancier une classe.
  public function getAllBooks()
  {

    // On effectue notre query SQL pour retourner un array de données
    $stmt = $this->pdo->query("SELECT * FROM books");
    return $stmt->fetchAll(PDO::FETCH_CLASS, "Book");
  }

  public function getOneBook()
  {
    $id = $this->checkQueryId();
    // On effectue notre query SQL pour retourner une donnée unique
    $query = $this->pdo->query("SELECT * FROM books WHERE id = $id");
    $query->setFetchMode(PDO::FETCH_CLASS, "Book");
    $book = $query->fetch();

    if (!$book) {
      // On redirige vers la page d'accueil
      $this->redirect();
      
    }

    return $book;
  }

  public function getOneBookById($id)
  {
    // On effectue notre query SQL pour retourner une donnée unique
    $query = $this->pdo->query("SELECT * FROM books WHERE id = $id");
    $query->setFetchMode(PDO::FETCH_CLASS, "Book");
    $book = $query->fetch();
    return $book;
  }

  
  // Méthode pour créer ou modifier un livre
  public function setupBook($setup)
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      // checkInputs() va nous retourner un tableau vide, ou avec une erreur;
      $error = $this->checkInputs();

      if (!count($error)) // Si l'array est vide / pas d'erreur
      {
        // $title = htmlspecialchars($_POST["title"]) => PHP 8
        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_URL);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        $description = htmlspecialchars($_POST['description']);

        // Nous utilisons PDO pour enregistrer ces données
        if ($setup === "create") {
          $stmt = $this->pdo->prepare("
            INSERT INTO books (title, author, image, price, description)
            VALUES (:title, :author, :image, :price, :description)
          ");
        } else if ($setup === "update") {
          $id = $this->checkQueryId();
          $stmt = $this->pdo->prepare("
            UPDATE books SET title = :title, author = :author, description = :description, image = :image, price = :price WHERE id = :id;
          ");
          $stmt->bindParam(":id", $id);
        }
        // On fait un bindParam pour éviter les injections SQL
        // On interdit une nouvelle requête à l'intérieur de notre requête principale
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author", $author);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":description", $description);
        
        if ($stmt->execute()) {
          $this->redirect();
        }
      } else { // Si on a une erreur, on retourne cette erreur
        return $error;
      }
    }
  }

  public function deleteBook()
  {
    // Suppression du livre
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      $id = $this->checkQueryId();
      $query = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
      $query->bindParam(":id", $id);

      // Si la suppression est validée, nous retournons sur la page d'accueil
      if ($query->execute())
      {
        $this->redirect();
      }
    }
  }


  // Cette méthode vérifie l'ID en query string et nous retourne cet ID
  private function checkQueryId()
  {
    // Nous vérifions si notre query ID existe bien, et a une valeur numéric
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      $this->redirect();
    }
    return (int)$_GET["id"];
  }


  private function checkInputs()
  {
    $error = [];
    if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['image']) || empty($_POST['price']) || empty($_POST['description']))
    {
      $error = ["Merci de compléter tous les champs."];
    }
  
    // On vérifie que notre input pour le prix est de type FLOAT / est NUMERIC
    else if (!is_numeric($_POST['price'])) {
      $error = ["Merci d'indiquer un prix valide"];
    }
  return $error;
  }


}