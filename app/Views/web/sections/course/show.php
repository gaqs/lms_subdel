<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Cursos <?= $this->endSection() ?>

<?= $this->section('main') ?>

<section id="course">
  <div class="container-fluid title_container gradient_background text-white">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-8">
          <h2 class="course_title"><?= $course->title ?></h2>
          <p class="course_description"><?= $course->resume ?></p>

          <div class="course_data my-5">
            <span class="qty_users"><i class="bi bi-people"></i> 20 personas |</span>
            <span class="qty_lessons"><i class="bi bi-file-earmark-text"></i> <?= $lessons_qty ?> lecciones |</span>
            <span class="last_update"><i class="bi bi-arrow-counterclockwise"></i> Última actualización, 
            <?php 
              $date = new DateTime($course->created_at);
              $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
              echo $formatter->format($date);
            ?> 
            </span>
          </div>
        </div> 
      </div>
    </div>
  </div>
  
  <div class="container mt-4">
    <div class="row">

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Acerca de este curso</h5>
            <p class="card-text">
              <span><b>Descripción</b></span><br>
              <?= $course->description ?>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 course_side mb-4">
        <div class="card w-100  ">
          <div class="card-img-top card_header">
            <img src="<?= base_url('uploads/courses/'.$course->image) ?>" class="w-100 h-100 object-fit-cover" alt="...">
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <b>Categoria</b> <span class="float-end"><?= $course->category_name ?></span>
              </li>
              <li class="list-group-item">
                <b>Lecciones</b> <span class="float-end"><?= $lessons_qty ?></span>
              </li>
              <li class="list-group-item">
                <b>Duracion</b> <span class="float-end"><?= $course->duration ?></span>
              </li>
              <li class="list-group-item">
                <b>Nivel</b> <span class="float-end"><?= $course->level ?></span>
              </li>
            </ul>
            <div class="d-flex">
              <a href="<?= base_url('courses/join?lesson_id='.$first); ?>" class="btn btn-success btn-lg my-3 me-2 flex-grow-1" onclick="return confirm('¿Está seguro que desea realizar el siguiente curso? Quedará añadido a su perfil.');">Ir al curso <i class="bi bi-arrow-right"></i></a>
              <a href="<?= base_url('user/user_save_wish?course_id='.$course->id); ?>" class="btn btn<?= empty($has_wish) ? '-outline':'' ?>-danger btn-lg my-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?= empty($has_wish) ? 'Guardar en favoritos':'Elliminar de favoritos' ?>">
                <i class="bi bi-heart"></i>
              </a>
            </div>
            
          </div>
        </div>
      </div>

      <div class="col-md-8 lessons_container mt-4">
        
        <div class="card border-0">
          <div class="card-body">
            <div class="card-title">
              <h5>Lecciones</h5>
            </div>
          </div>
          
          <div class="accordion" id="modules_accordion">
            
            <?php $count_m=1; if(isset($module)): foreach($module as $m): ?>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button <?= ($count_m != 1 ? 'collapsed': '')?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= 'modulo_'.$m->id ?>" aria-expanded="<?= ($count_m == 1 ? 'true': 'false')?>" aria-controls="collapseOne">
                  <?= 'Módulo '.$count_m.': '.$m->title ?>
                </button>
              </h2>
              <div id="<?= 'modulo_'.$m->id ?>" class="accordion-collapse collapse <?= ($count_m == 1 ? 'show': '')?>" data-bs-parent="#modules_accordion">
                <div class="accordion-body">
                  <ul class="list-group list-group-flush">

                    <?php $count_l = 1; if(isset($lessons)): foreach ($lessons[$m->id] as $lesson): ?>

                    <li class="list-group-item">
                      <i class="bi bi-lock me-2"></i>

                      <i class="bi bi-play-btn"></i> 
                      
                      <?= 'Lección '.$count_l.': '.$lesson->title ?> 
                      <span class="float-end"><?= $lesson->duration ?></span> 
                    </li>

                    <?php $count_l++; endforeach; endif; ?>

                  </ul>
                </div>
              </div>
            </div>

            <?php $count_m++; endforeach; endif; ?>

          </div>

        </div>
        
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="profile_card text-center">
              <div class="profile_cover"></div>
              <div class="profile_info">
                <div class="profile_initial d-flex justify-content-center">
                  <div class="letter uppercase"><?= substr($course->username,0,1) ?></div>
                </div>
                <h4><?= $course->username.' '.$course->userlastname ?></h4>
                <p><?= $course->useremail ?></p>
                <button class="btn btn-success mt-3">Saber más <i class="bi bi-arrow-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?= $this->endSection() ?>