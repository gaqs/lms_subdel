<!DOCTYPE html>
<html lang="es" dir=""ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Primary Meta Tags -->
  <title><?= $this->renderSection('title', true) ?></title>
  <meta name="title" content="...">
  <meta name="description" content="...">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://default.com/">
  <meta property="og:title" content="...">
  <meta property="og:description" content="...">
  <meta property="og:image" content="<?= base_url('img/default.jpg');?>">

  <!-- Twitter -->
  <meta property="twitter:card" content="website">
  <meta property="twitter:url" content="https://default.com/">
  <meta property="twitter:title" content="...">
  <meta property="twitter:description" content="...">
  <meta property="twitter:image" content="<?= base_url('img/default.jpg');?>">

  <!-- Icon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('img/default.png');?>">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- Css -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/bootstrap-5.3.3/css/bootstrap.css');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/bootstrap-icons-1.11.3/font/bootstrap-icons.css');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/hover.css?v=0.01');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/styles.css?v=0.05');?>">

</head>
<body>
  <header>
    <?= $this->include('web/layout/navbar') ?>
  </header>
  <main role="main" class="main_container" style="margin-top:80px;">
    <?= $this->renderSection('main') ?>
  </main>
  <footer>
    <?= $this->include('web/layout/footer') ?>
  </footer>
