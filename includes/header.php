<?php
session_start();
require_once "./vendor/autoload.php";
require_once dirname(__DIR__) . "/utils/utils.php";
require_once dirname(__DIR__) . "/configs/configs.php";
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
$user = getLoggedUser();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Bookstore</title>
</head>
<body class="bg-slate-50">
  <nav class="shadow-md py-6 mb-20 bg-white">
    <div class="container mx-auto flex justify-between items-center">
      <a href="index.php">
        <h4 class="text-4xl font-light">Bookstore</h4>
      </a>
      <ul class="list-none flex gap-6 justify-between items-center">
        <?php if($user): ?>
          <?php if($user["role"] === "admin"): ?>
            <li>
              <a class="text-gray-600 hover:text-gray-700" href="create.php">
                <i class="fa-solid fa-circle-plus mr-2"></i>Ajouter un livre
              </a>
            </li>
          <?php endif ?>
          <li>
            <a class="text-gray-600 hover:text-gray-700" href="profile.php">
              <i class="fa-solid fa-user mr-2"></i> Bonjour <?= $user["firstname"] ?>
            </a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-700" href="basket.php">
              <i class="fa-solid fa-cart-shopping mr-2"></i> Mon panier
            </a>
          </li>
          <li>
            <form action="logout.php" class="ml-6" method="post">
              <button class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-power-off fa-xl"></i>
              </button>
            </form>
          </li>
        <?php else: ?>
          <li>
            <a class="text-gray-600 hover:text-gray-700" href="login.php">
              <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Se connecter
            </a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-700" href="register.php">
              <i class="fa-solid fa-inbox mr-2"></i> S'enregistrer
            </a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  </nav>

  <main class="container mx-auto">