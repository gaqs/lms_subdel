<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Inicio <?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php if (session('error') !== null) : ?>
<div class="alert alert-dismissible fade show alert-danger alert_home">
  <?= session('error') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>

<section class="py-5 mb-5 gradient_background" id="header_carousel">
  <div class="container">
    <div class="row text-white">
      <div class="col align-self-center">

        <img src="<?= base_url('img/logo_muni.png');?>" alt="" class="mb-3" style="width:200px;">
        <h5>Plataforma de aprendizaje online</h5>
        <h1 class="display-3 lh-1 fw-bolder">Únete & <span class="text-success">aprende</span> de manera efectiva</h1>
        <p>Explora nuevas habilidades más allá del mundo del conocimiento y pierdete en la libertad de la creatividad.</p>
        <a href="<?= base_url('login') ?>" class="btn btn-success px-5 py-2">Iniciar <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="col d-none d-md-none d-lg-block">
        <img src="<?= base_url('img/header.png'); ?>" alt="" class="w-100">
      </div>
    </div>
  </div>
</section>

<section class="pt-5 mb-5" id="courses">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-4">
        <h3 class="fw-bold mb-1 lh-1">Nuestros Cursos</h3>
        <p class="text-secondary">hacemos que aprender sea conveniente, asequible y divertido.</p>
      </div>

      <div class="col-md-12 mb-5">
        <div class="d-flex justify-content-center">
          <ul class="nav nav-pills justify-content-center">
            <li class="nav-item"> 
              <button class="nav-link active nav_category" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Todas las Categorias</button>
            </li>
            <?php $count = 0; foreach($categories as $cat):?>
            <li class="nav-item" role="presentation">
              <button class="nav-link nav_category" id="<?= 'id_'.$cat->id ?>" data-bs-toggle="tab" data-bs-target="<?= '#cat-'.$cat->id.'-pane' ?>" type="button" role="tab" aria-controls="<?= '#cat-'.$cat->id.'-pane' ?>" aria-selected="true">
                <?= $cat->name ?>
              </button>
            </li>
            <?php $count++; endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="col-md-12">
        <div class="tab-content" id="category-content">
          <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="row row-cols-1 row-cols-md-3 g-4">
              <!-- all courses no category -->
              <?php $course_count = 0; foreach ($courses as $c): if($course_count < 6 ): ?>
                <div class="col-md-4 mb-4">
                  <div class="card w-100 hvr-float">
                    <div class="card-img-top card_header">
                      <img src="<?= base_url('uploads/courses/'.$c->image); ?>" class="w-100 h-100 object-fit-cover" alt="...">
                    </div>
                    <div class="card-body position-relative">
                      <div class="post_date position-absolute">
                        <?php 
                          $date = new DateTime($c->created_at);
                          $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                          echo $formatter->format($date);
                        ?>
                      </div>
                      <h5 class="card-title mt-3"><?= $c->title; ?></h5>
                      <p class="card-text">
                        <?= substr( $c->description, 0, 100).'...'; ?>
                      </p>
                      <small>
                        <div class="row">
                          <div class="col-12">
                            <i class="bi bi-person"></i> Por <?= $c->name.' '.$c->lastname; ?> | 
                            <i class="bi bi-file-earmark-text"></i> <?= $c->lesson_qty.' lecciones  ' ?>
                          </div>
                          <div class="col-12">
                            <a href="<?= base_url('courses/show/'.$c->id); ?>" class="float-end">DETALLES <i class="bi bi-arrow-right"></i></a>
                          </div>
                        </div>
                      </small>
                    </div>
                  </div>
                </div>
              <?php $course_count++; endif; endforeach; ?>
            </div>
          </div>

          <?php $count = 0; foreach($categories as $cat): ?>
          <div class="tab-pane fade" id="<?= 'cat-'.$cat->id.'-pane' ?>" role="tabpanel" aria-labelledby="<?= '#cat-'.$cat->id ?>" tabindex="0">
            <div class="row row-cols-1 row-cols-md-3 g-4">

              <?php $course_count = 0; foreach ($courses as $c): if($c->category_id == $cat->id && $course_count < 6 ): ?>

                <div class="col-md-4 mb-4">
                  <div class="card w-100 hvr-float">
                    <div class="card-img-top card_header">
                      <img src="<?= base_url('uploads/courses/'.$c->image); ?>" class="w-100 h-100 object-fit-cover" alt="...">
                    </div>
                    <div class="card-body position-relative">
                      <div class="post_date position-absolute">
                        <?php 
                          $date = new DateTime($c->created_at);
                          $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                          echo $formatter->format($date);
                        ?>
                      </div>
                      <h5 class="card-title mt-3"><?= $c->title; ?></h5>
                      <p class="card-text">
                        <?= substr( $c->description, 0, 100).'...'; ?>
                      </p>
                      <small>
                        <div class="row">
                          <div class="col-12">
                            <i class="bi bi-person"></i> Por <?= $c->name.' '.$c->lastname; ?> | 
                            <i class="bi bi-file-earmark-text"></i> <?= $c->lesson_qty.' lecciones  ' ?>
                          </div>
                          <div class="col-12">
                            <a href="<?= base_url('courses/show/'.$c->id); ?>" class="float-end">DETALLES <i class="bi bi-arrow-right"></i></a>
                          </div>
                        </div>
                      </small>
                    </div>
                  </div>
                </div>
              
              <?php $course_count++; endif; endforeach; ?>

            </div>
          </div>
          <?php $count++; endforeach; ?>

        </div>  
      </div>

    </div>
  
  </div>
</section>

<section id="about-us" class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-4">
        <h3 class="fw-bold mb-1 lh-1">Acerca de Nosotros</h3>
        <p class="text-secondary">¿Quienes somos?</p>
      </div>
      <div class="col-md-7">
        <p>Bienvenido/a a nuestra plataforma de aprendizaje en línea, una iniciativa de la <b>Subdirección de Desarrollo Económico Local</b> de la Municipalidad de Puerto Montt. Este espacio está diseñado para potenciar el desarrollo personal y profesional de nuestra comunidad.</p>
        <p>Aquí encontrarás una amplia variedad de cursos cuidadosamente seleccionados, impartidos por expertos instructores comprometidos con tu crecimiento.</p>
        <p>Nuestra misión es hacer que el aprendizaje sea:</p>
        <p>
          <ul>
            <li>Conveniente: Estudia a tu propio ritmo y desde cualquier lugar</li>
            <li>Asequible: Accede a contenido de calidad sin barreras</li>
            <li>Divertido: Aprende de manera interactiva y práctica</li>
          </ul>
        </p>
        <p>Ya sea que busques desarrollar nuevas habilidades, profundizar en tus conocimientos o explorar nuevas áreas de interés, estamos aquí para acompañarte en tu viaje de aprendizaje.</p>
        <p>Esta plataforma ha sido desarrollada por la <b>Dirección de Desarrollo Comunitario (DIDECO)</b> de Puerto Montt, bajo la supervisión de Gustavo Quilodrán Sanhueza, como parte de nuestro compromiso con el desarrollo económico local y la educación continua.</p>
        <p>Para consultas o más información:</p>
        <p>
          <ul>
            <li>Correo: contacto@subdelpuertomontt.cl</li>
            <li>Teléfono: (+65) 2 261315 / (+65) 2 261306</li>
            <li>Dirección: Av. Presidente Ibañez #600, Edificio Consistorial II, 2do piso.</li>
          </ul>
        </p>
        <p>¡Únete a nuestra comunidad educativa y comienza tu camino hacia el éxito!</p>
      </div>
      <div class="col-md-5">
        <img src="<?= base_url('public/img/dideco_logo_2.png') ?>" alt="" class="w-100">
        <img src="<?= base_url('public/img/logo_muni.png') ?>" alt="" class="w-100">
      </div>
    </div>
  </div>
</section>

<section id="help" class="py-5">

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12 text-center mb-4">
            <h3 class="fw-bold mb-1 lh-1">¿Dudas? ¿Consultas?</h3>
            <p class="text-secondary">Escribenos</p>
          </div>

          <div class="col-md-5 map-responsive mb-3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2989.9058013904387!2d-72.93980168488679!3d-41.46295835924439!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x96183af88b9f7211%3A0x787f6c3c86477910!2sMunicipalidad%20Puerto%20Montt%20edificio%20consistorial%20II!5e0!3m2!1ses-419!2scl!4v1651779781328!5m2!1ses-419!2scl" width="100%" height="100%" style="border:0;" allowfullscreen></iframe>
          </div>
            <div class="col-md-7">

                <div class="card border-0 rounded-lg">
                  <?php
                  if (session('error') !== null) {
                    showFlashMessage('error', session('error'));
                  }elseif (session('errors') !== null) {
                    showFlashMessage('error', implode('<br>', session('errors')));
                  }elseif (session('success') !== null) {
                    showFlashMessage('success', session('success'));
                  }
                  ?>
                    <div class="card-body">
                      <form action="<?= base_url('/help');?>" method="post">
                      <div class="row">
                        <div class="col-md-7">
                          <div class="mb-3">
                            <label for="input_name"><b>Nombre Completo</b></label>
                            <input type="text" class="form-control" id="input_name" name="name" placeholder="">
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="mb-3">
                            <label for="input_phone"><b>Teléfono</b></label>
                            <input type="text" class="form-control" id="input_phone" name="phone" placeholder="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="input_email"><b>Correo electrónico</b></label>
                            <input type="email" class="form-control" id="input_email" name="email" placeholder="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="input_subject"><b>Asunto</b></label>
                            <input type="text" class="form-control" id="input_subject" name="subject" placeholder="">
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="">
                            <label for="textarea_message"><b>Mensaje</b></label>
                            <textarea class="form-control" placeholder="" id="textarea_message" name="message" style="height:100px;"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mt-4 mb-0">
                        <button type="submit" class="btn btn-success submit_something w-100">
                          <i class="fa-solid fa-paper-plane"></i> Enviar mensaje
                        </button>
                      </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
</section>



<?= $this->endSection() ?>