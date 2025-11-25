<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Inicio <?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php if (session('error') !== null) : ?>
<div class="alert alert-dismissible fade show alert-danger alert_home">
  <?= session('error') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>

<section id="certificate" class="sections">

  <div class="container">
    <div class="row">
      <div class="col-md-10">

          <h2>Certificado de Finalización</h2>
          <p class="text-secondary">El siguiente certificado garantiza que <i><?= $course->name.' '.$course->lastname ?></i> ha completado con éxito el curso <a href="#"><?= $course->course_name ?></a> a fecha de <i><?= date('d-m-Y', strtotime($course->updated_at)) ?></i>. El certificado indica que se ha completado la totalidad del curso, según lo validado por el estudiante. La duración del curso representa el total de horas de vídeo y un aproximado en las horas segun la cantidad de documentos del curso en el momento de finalización más reciente.</p>

          <iframe id="pdf_viewer" class="w-100" style="height:800px;" src="<?= $pdfPath ?>"></iframe>

      </div>
      <div class="col-md-2">

      </div>
  </div>

</section>




<?= $this->endSection() ?>