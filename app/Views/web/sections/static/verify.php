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
    <div class="row justify-content-center">
      <div class="col-6">
        <h2>Verificar Certificado de Finalización</h2>
        <p>Existen dos maneras de verificar su certificado de finalización de curso, por link o codigo que comienza con "CERT-"" que tambien se encuentra en el mismo certificado</p>

        <p>Ingresa el código de tu certificado para verificar su autenticidad.</p>

        <form action="<?= base_url('verify-certificate') ?>" method="GET">
            <div class="mb-3">
                <label for="token" class="form-label">Código del Certificado</label>

                <div class="input-group mb-3">
                    <span class="input-group-text">CERT-</span>
                    <input type="text" class="form-control" id="code" name="code" value="" required>
                </div>    
            </div>
            <button type="submit" class="btn btn-success">Verificar</button>
        </form>
        <br>
        <div id="result">
            <?php 
            
                if( !isset($verify) ):
                    echo '<i>'.$error.'</i>';
                else:
            ?>

                <h5>Certificado Verificado</h5>
                <p>El certificado ha sido verificado exitosamente. Los detalles del certificado son los siguientes:</p>
                <ul>
                    <li><strong>Nombre del Estudiante:</strong> <?= $verify->name.' '.$verify->lastname ?></li>
                    <li><strong>Nombre del Curso:</strong> <?= $verify->course_name ?></li>
                    <li><strong>Duración del Curso:</strong> <?= round_duration_to_hours($verify->duration) ?> horas</li>
                    <li><strong>Fecha de Finalización:</strong> <?= beautiful_date($verify->updated_at) ?></li>
                    <li><strong>Código del Certificado:</strong> <?= $verify->code ?></li>
                    <li><strong>Token del Certificado:</strong> <?= $verify->token ?></li>
                </ul>

            <?php endif; ?>

        </div>

      </div>
  </div>

</section>




<?= $this->endSection() ?>