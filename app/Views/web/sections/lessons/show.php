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
                <video id="lesson_video" class="video-js mt-4 w-100 h-100" controls preload="auto">
                  <source src="<?=base_url('public/uploads/lessons/'.$content->file) ?>" type="video/mp4">
                </video>
              </div>
          
          <?php elseif($ext == '.pdf'):?>
          
            <div id="pdf_navigation" class="d-flex mb-2 justify-content-center align-items-center">
              <div id="zoom">
                <button id="zoomout" class="btn btn-success me-1"><i class="bi bi-zoom-out"></i></button>
                <button id="zoomin" class="btn btn-success me-2"><i class="bi bi-zoom-in"></i></button>
              </div>
              <button id="prev_page" class="btn btn-success me-2">Anterior</button>
              <div id="page_info">
                Página <span id="current_page">0</span> de <span id="total_pages">0</span>
              </div>
              <button id="next_page" class="btn btn-success ms-2">Siguiente</button>
              <div id="zoom">
                <button id="download" class="btn btn-success ms-2 me-1 disabled"><i class="bi bi-cloud-arrow-down"></i></button>
                <button id="print" class="btn btn-success disabled"><i class="bi bi-printer"></i></button>
              </div>
            </div>
            <div id="pdf_container" class="w-100 text-center overflow-scroll border border-black" style="height:800px;">
              <canvas id="pdf_canvas"></canvas>
            </div>
          <!--
          <iframe class="w-100" height="800" src="<?= base_url('dist/pdfjs-4.9.124/web/viewer.html?file=').base_url('public/uploads/lessons/'.$content->file) ?>" frameborder="0"></iframe>
          -->
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
                       
                        <div class="form-check d-inline ps-0">
                  
                          <input class="form-check-input check_lesson" type="checkbox" value="<?= $lesson->id ?>" <?= ($lesson->completed  == '100' ? 'checked':'')?>>
                        </div>

                          <!-- cambiar icono si es video o coumento pdf -->
                          <?= type_lesson_file($lesson->file) ?>
                          
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
            
            <div id="progress_bar" class="mt-5">
              <div class="mb-3">
                <h5>Progreso del curso</h5>
              </div>
              <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar bg-success" style="width: <?= $progress ?>%"><?= $progress ?>%</div>
              </div>
              <div class="float-end mt-3"> 
                <a href="">Actualizar progreso</a>
              </div>
            </div>





          </div>
        </div>

      </div>

  </div>
</section>

<?= $this->endSection() ?>