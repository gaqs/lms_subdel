<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Administrador <?= $this->endSection() ?>


<?= $this->section('main') ?>

<div class="container">
  <div class="row">
    <div class="col-md-12 mt-3 mt-5 ms-2 text-center">
      <h2>Bienvenido/a <?= auth()->user()->name.' '.auth()->user()->lastname ?></h2>
    </div>
  </div>
</div>

<?= $this->endSection() ?>