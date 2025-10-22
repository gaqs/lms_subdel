<!DOCTYPE html>
<html lang="es" dir=""ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Primary Meta Tags -->
  <title><?= $this->renderSection('title', true) ?></title>
  <meta name="title" content="...">
  <meta name="description" content="...">

    <!-- Icon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('img/default.png');?>">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- Css -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/bootstrap-5.3.3/css/bootstrap.css');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/bootstrap-icons-1.11.3/font/bootstrap-icons.css');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/datatables-2.1.3/datatables.css');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/hover.css?v=0.01');?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('dist/trumbowyg-2.28.0/ui/trumbowyg.css');?>">
  <link rel="stylesheet" type="text/css" href="//vjs.zencdn.net/8.3.0/video-js.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('css/styles.css?v=0.06');?>">

  <script type="text/javascript" src="<?= base_url('js/jquery-3.7.1.min.js'); ?>"></script>

  <script type="text/javascript" src="<?= base_url("dist/Sortable-1.15.6/Sortable.min.js"); ?>"></script>

</head>
<body>
  

  <div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0 d-flex">
            <?= $this->include('admin/layout/sidebar'); ?>
        </div>
        <main role="main" class="col p-0 main_container">

          <header>
            <?= $this->include('admin/layout/navbar') ?>
          </header>

          <?= $this->renderSection('main') ?>

        </main>
    </div>
</div>

  <footer>
    <?= $this->include('admin/layout/footer') ?>
  </footer>
