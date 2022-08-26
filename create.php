<?php
require_once "./includes/header.php";
require_once "./src/BookModel.php";

isAdmin();
$bookModel = new BookModel();
$error = $bookModel->setupBook("create");


?>

<form method="post" class="w-1/2 mx-auto bg-white border rounded p-4 shadow-md">
  <h1 class="text-6xl font-light text-center mb-10 uppercase">Ajouter un livre</h1>

  <?php if(isset($error) && count($error) > 0): ?>
    <div class="bg-red-400 text-red-800 py-4 px-8 rounded border border-red-800 mb-10">
      <p><?= $error[0] ?></p>
    </div>
  <?php endif ?>

  <div class="mb-4">
    <label class="block mb-2" for="title">Titre du livre:</label>
    <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="title" id="title">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="author">Auteur du livre:</label>
    <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="author" id="author">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="image">Image du livre:</label>
    <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="text" name="image" id="image">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="price">Prix du livre:</label>
    <input class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" type="number" step="0.01" name="price" id="price">
  </div>

  <div class="mb-4">
    <label class="block mb-2" for="description">Description du livre:</label>
    <textarea class="border rounded border-gray-100 py-2 px-4 w-full outline-none shadow-sm" name="description" id="description" rows="10"></textarea>
  </div>

  <button class="w-full rounded p-4 bg-blue-400 hover:bg-blue-500 text-white font-semibold">
  <i class="fa-solid fa-file-circle-plus mr-2"></i>Envoyer
  </button>
</form>

<?php require_once "./includes/footer.php" ?>