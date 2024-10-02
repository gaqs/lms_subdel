<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Inicio <?= $this->endSection() ?>


<?= $this->section('main') ?>

<section class="py-5" id="header_carousel">
  <div class="container">
    <div class="row text-white">
      <div class="col align-self-center">
        <h5>Plataforma de aprendizaje online</h5>
        <h1 class="display-3 lh-1 fw-bolder">Únete & <span class="text-success">aprende</span> de manera efectiva</h1>
        <p>Explora nuevas habilidades más allá del mundo del conocimiento y pierdete en la libertad de la creatividad.</p>
        <button class="btn btn-success px-5 py-2">Iniciar <i class="bi bi-arrow-right"></i></button>
      </div>
      <div class="col">
        <img src="<?= base_url('img/header.png'); ?>" alt="" class="w-100">
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    Nuestros Cursos
  </div>
</section>

<?= $this->endSection() ?>