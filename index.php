<?php


require_once "./includes/header.php";
require_once "./src/BookModel.php";

// On instancie notre BookModel
// Puis on utilise la méthode getAllBooks() pour récupérer les livres
$bookModel = new BookModel();
$books = $bookModel->getAllBooks();

foreach($books as $book) {
  require "./components/book_card.php";
}

require_once "./includes/footer.php";
  