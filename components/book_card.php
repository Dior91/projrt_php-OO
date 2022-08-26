<div class="bg-white flex justify-between items-center shadow-sm mb-6 p-6">
  <img class="w-36" src="<?= $book->getImage() ?>" alt="">
  <div class="w-1/3">
    <h2 class="text-4xl uppercase"><?= $book->getTitle() ?></h2>
    <h3 class="text-2xl font-light"><?= $book->getAuthor() ?></h3>
    <h4 class="text-2xl font-light text-red-400"><?= $book->getPrice() ?> €</h4>
  </div>
  <a href="details.php?id=<?= $book->getId() ?>" class="py-2 px-4 rounded bg-blue-400 hover:bg-blue-500 text-white">
    <i class="fa-solid fa-eye mr-2"></i>Voir plus
  </a>
</div>
</div>