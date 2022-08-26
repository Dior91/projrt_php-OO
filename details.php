<?php
require_once "./includes/header.php";
require_once "./src/BookModel.php";
require_once "./src/BasketModel.php";
$bookModel = new BookModel();
$basketModel = new BasketModel();
$book = $bookModel->getOneBook();
$basketModel->addToBasket($book->getId());
$bookModel->deleteBook();
$user = getLoggedUser();
?>

<section class="rounded overflow-hidden bg-white shadow-md">
  <header class="py-4 bg-gray-800 text-white">
    <h1 class="text-6xl text-center font-light uppercase"><?= $book->getTitle() ?></h1>
  </header>

  <div class="flex p-10 gap-6">
    <div class="w-1/3">
      <img class="max-w-full" src="<?= $book->getImage() ?>" alt="<?= $book->getTitle() ?>">
    </div>

    <div class="w-2/3">
      <h2 class="text-4xl font-light"><?= $book->getAuthor() ?></h2>
      <h3 class="text-4xl text-red-400"><?= $book->getPrice() ?> €</h3>

      <div class="mt-10">
        <p>Description:</p>
        <hr class="my-6"/>
        <p><?= $book->getDescription() ?></p>
      </div>

      <?php if($user): ?>
        <div class="mt-10 flex items-center gap-3">
          <a class="text-gray-400 hover:text-red-500" href="">
            <i class="fa-solid fa-heart mr-2"></i> J'aime
          </a>
          <form method="post">
            <button class="text-blue-400 hover:text-blue-500">
              <i class="fa-solid fa-cart-arrow-down mr-2"></i> Ajouter au panier
            </button>
          </form>
        </div>

        <?php if($user["role"] === "admin"): ?>
          <div class="mt-10 flex items-center gap-3">
            <a href="edit.php?id=<?= $book->getId() ?>" class="py-2 px-4 rounded bg-yellow-400 hover:bg-yellow-500 text-white">
              <i class="fa-solid fa-pen-to-square mr-2"></i>Éditer
            </a>
            <form method="post" onsubmit="return confirm('Supprimer ce livre ?')">
              <button class="py-2 px-4 rounded bg-red-400 hover:bg-red-500 text-white">
                <i class="fa-solid fa-ban mr-2"></i>Supprimer
              </button>
            </form>
          </div>
        <?php endif ?>
      <?php endif ?>

      <div class="mt-10 text-right">
        <a class="text-gray-700 hover:text-gray-800" href="index.php">
          <i class="fa-solid fa-backward mr-2"></i> Retour
        </a>
      </div>
    </div>
  </div>
</section>

<?php
require_once "./includes/footer.php";