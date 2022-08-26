<?php
require_once "MainModel.php";
require_once "Book.php";
require_once "BookModel.php";

class BasketModel extends MainModel
{
  /**
   * Méthode pour retourner notre panier
   */
  public function getBasket()
  {
    $bm = new BookModel();
    $user = getLoggedUser();
    $userId = $user["id"];
    $query = $this->pdo->query("
    select bb.book_id, bb.quantity from basket b
    join basket_books bb 
    on basket_id = b.id
    where user_id = $userId
    ");
    $basket = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if ($basket)
    {
      $formatedBasket = [];
      foreach($basket as $book)
      {
        $newBook = $bm->getOneBookById($book["book_id"]);
        $newBook->setQuantity($book["quantity"]);
        $formatedBasket[] = $newBook;
      }
      return $formatedBasket;
    }

    return false;
  }

  /**
   * Méthode pour calculer le prix du panier
   */
  public function getFullPrice($basket)
  {
    if (!$basket) return;
    $total = 0;
    foreach($basket as $book)
    {
      $total = $total + $book->getPrice() * $book->getQuantity();
    }
    return $total;
  }
  
  /**
   * Méthode pour ajouter un livre à notre panier
   */
  public function addToBasket($bookId)
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
      // 1ère étape: vérifier si le panier existe ou pas
      $user = getLoggedUser();
      $query = $this->pdo->query("SELECT * FROM basket WHERE user_id = " . $user["id"]);
      $basket = $query->fetch(PDO::FETCH_ASSOC);

      if (!$basket)
      {
        $query = $this->pdo->prepare("INSERT INTO basket (user_id) VALUES (:user_id)");
        $query->execute([":user_id" => $user["id"]]);
        // On récupère l'ID de notre nouveau panier
        $basketId = $this->pdo->lastInsertId();


        $query = $this->pdo->prepare("INSERT INTO basket_books (basket_id, book_id, quantity) VALUES (:basket_id, :book_id, 1)");
        $query->execute([":basket_id" => $basketId, ":book_id" => $bookId]);
      }
      else 
      {
        // Si le panier existe, on vérifie si le livre est déjà présent à l'intérieur
        $query = $this->pdo->query("SELECT * FROM basket_books 
        WHERE basket_id = " . $basket["id"] . " AND book_id = " . $bookId);
        $book = $query->fetch(PDO::FETCH_ASSOC);
        
        // Si le livre existe, on augmente sa quantité
        if ($book)
        {
          $query = $this->pdo->prepare("
            UPDATE basket_books SET quantity = :quantity WHERE book_id = :book_id
          ");
          $query->execute([":quantity" => $book["quantity"] + 1, ":book_id" => $book["book_id"]]);
        }
        else {
          $query = $this->pdo->prepare("INSERT INTO basket_books (basket_id, book_id, quantity) VALUES (:basket_id, :book_id, 1)");
          $query->execute([":basket_id" => $basket["id"], ":book_id" => $bookId]);
        }
      }

      $this->redirect("basket.php");
    }
  }

  /**
   * Méthode pour supprimer un livre du panier
   */
  public function removeToBasket($bookId)
  {
    // 1ère étape: récupérer le panier
    $user = getLoggedUser();
    $query = $this->pdo->query("SELECT * FROM basket WHERE user_id = " . $user["id"]);
    $basket = $query->fetch(PDO::FETCH_ASSOC);

    // 2nde étape: récupérer le livre pour vérifier sa quantité
    $query = $this->pdo->query("SELECT * FROM basket_books 
    WHERE basket_id = " . $basket["id"] . " AND book_id = " . $bookId);
    $book = $query->fetch(PDO::FETCH_ASSOC);

    // Si le livre a une quantité supérieur à 1
    if ($book["quantity"] > 1)
    {
      $query = $this->pdo->prepare("
        UPDATE basket_books SET quantity = :quantity WHERE book_id = :book_id
      ");
      $query->execute([":quantity" => $book["quantity"] - 1, ":book_id" => $bookId]);
    }
    else if ($book["quantity"]  === "1")
    {
      $query = $this->pdo->prepare("
        DELETE FROM basket_books WHERE book_id = :book_id AND basket_id = :basket_id
      ");
      $query->execute([":book_id" => $bookId, ":basket_id" => $basket["id"]]);
    }

    $this->redirect("basket.php");
  }
}