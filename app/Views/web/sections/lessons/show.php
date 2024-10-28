<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Cursos <?= $this->endSection() ?>


<?= $this->section('main') ?>

<section id="course_start">
  <div class="container-fluid title_container text-white">

      <div class="row">
        <div class="col-md-12 text-black mt-4">
          <h2 class="course_title">Curso: <?= $course->title ?></h2>
          <p class="course_description"><?= $course->resume ?></p>
          <hr>
        </div>
        <div class="col-md-8 text-black">
          
          <!-- lesson content -->
          <h4 class="mt-3"><?= $content->title ?></h4>
          <p><?= $content->description ?></p>

          <?php  
            if( !empty($content->file) ):
              $ext = strtolower( substr( $content->file, -4));
              if($ext == '.mp4'):
          ?>
              <div class="file_container position-relative mt-3">
                <video class="video-js mt-4 w-100 h-100" controls>
                  <source src="<?=base_url('public/uploads/lessons/'.$content->file) ?>" type="video/mp4">
                </video>
              </div>
          
          <?php elseif($ext == '.pdf'):?>
            <div class="file_container position-relative mt-3">
              <embed src="<?=base_url('public/uploads/lessons/'.$content->file) ?>" type="application/pdf" height="700" style="width:100%;">
            </div>
          <?php 
              endif;
            endif 
          ?>

        </div> 

        <div class="col-md-4 lessons_container">
          <div class="card border-0">
            <div class="card-body">
              <div class="card-title">
                <h5>Lecciones</h5>
              </div>
            </div>
            
            <div class="accordion" id="modules_accordion">
              
              <?php $uri = service('uri'); $count_m=1; if(isset($module)): foreach($module as $m): ?>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button <?= in_array($uri->getSegment(3), array_column($lessons[$m->id], 'id')) ? '' : 'collapsed'?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= 'modulo_'.$m->id ?>" aria-expanded="<?= in_array($uri->getSegment(3), array_column($lessons[$m->id], 'id')) ? 'true' : 'false'?>" aria-controls="collapseOne">
                    <?= 'Módulo '.$count_m.': '.$m->title ?>
                  </button>
                </h2>
                <div id="<?= 'modulo_'.$m->id ?>" class="accordion-collapse collapse <?= in_array($uri->getSegment(3), array_column($lessons[$m->id], 'id')) ? 'show' : ''?>" data-bs-parent="#modules_accordion">
                  
                  <div class="accordion-body">
                    <ul class="list-group list-group-flush">

                      <?php $count_l = 1; if(isset($lessons)): foreach ($lessons[$m->id] as $lesson): ?>
                      
                      <li class="list-group-item">
                        <a href="<?= base_url('lesson/show/'.$lesson->id) ?>" class="<?= $lesson->id != $uri->getSegment(3) ? 'text-black fw-normal' : '' ?>">
                          <i class="bi bi-unlock me-2"></i>
                          <i class="bi bi-play-btn"></i> 
                          <?= 'Lección '.$count_l.': '.$lesson->title ?> 
                          <span class="float-end"><?= $lesson->duration ?></span> 
                        </a>
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

      </div>

  </div>
</section>

<?= $this->endSection() ?>