<?php
require_once "./includes/header.php";
require_once "./src/BasketModel.php";
isLogged();

$bm = new BasketModel();
$basket = $bm->getBasket();
$total = $bm->getFullPrice($basket);

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
  if ($_GET["action"] === "add") $bm->addToBasket($_GET["book_id"]);
  else if ($_GET["action"] === "remove") $bm->removeToBasket($_GET["book_id"]);
}
?>

<h1 class="text-center text-6xl font-light"><?= $basket ? "Mon panier" : "Votre panier est vide" ?></h1>

<section class="mt-10 flex gap-10">
  <div class="w-2/3">
    <?php if($basket): ?>
      <?php foreach($basket as $book): ?>
        <!-- CARTE -->
        <div class="bg-white flex justify-between items-center shadow-sm mb-6 p-3">
          <a href="details.php?id=9">
            <img class="w-20" src="<?= $book->getImage() ?>" alt="<?= $book->getTitle() ?>">
          </a>
          <div class="w-1/3">
            <h2 class="text-4xl uppercase">
            <a href="details.php?id=<?= $book->getId() ?>">
              <?= $book->getTitle() ?>
              </a>
            </h2>
            <h3 class="text-2xl font-light"><?= $book->getAuthor() ?></h3>
            <h4 class="text-2xl font-light text-red-400"><?= $book->getPrice() ?> €</h4>
          </div>
          <div>
            <p class="font-semibold">Quantité: <?= $book->getQuantity() ?></p>
            <div class="flex items-center gap-6 mt-3">
              <form method="post" action="basket.php?book_id=<?= $book->getId() ?>&action=remove">
                <button>
                  <i class="fa-solid fa-circle-minus text-blue-400 hover:text-blue-500 fa-2xl"></i>
                </button>
              </form>
              <form method="post" action="basket.php?book_id=<?= $book->getId() ?>&action=add">
                <button>
                  <i class="fa-solid fa-circle-plus text-blue-400 hover:text-blue-500 fa-2xl"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <!-- FIN CARTE -->
      <?php endforeach ?>
    <?php endif ?>

    <?php if($basket): ?>
      <h2 class="text-right text-4xl font-light">Total de la commande: <span id="totalPrice"><?= $total ?></span> €</h2>
    <?php endif ?>
  </div>
  <div class="w-1/3"></div>
</section>

<script>
  const price = Number(document.querySelector("#totalPrice").innerText)
  document.querySelector("#totalPrice").innerText = price.toFixed(2)
</script>

<?php require_once "./includes/footer.php";