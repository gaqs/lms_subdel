<?= $this->extend('shield/sections/home') ?>
<?= $this->section('user_main') ?>

<h5 class="card-title">Mis Favoritos</h5>
  <hr>
  <div class="row">
    <?php
    if(!empty($courses)): 
      foreach ($courses as $c): 
    ?>
    <div class="col-md-4 mb-4">
      <div class="card w-100 hvr-float">
        <div class="card-img-top card_header">
        <div class="position-absolute l-0 t-0 bg-primary py-1 px-4 rounded text-white top-0 start-0">CURSO</div>
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
          <small>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-between mt-3">
                <a href="<?= base_url('user/user_save_wish?course_id='.$c->id); ?>" class="text-danger" onclick="return confirm('¿Está seguro de querer eliminar el curso de favoritos?');"><i class="bi bi-heartbreak"></i> ELIMINAR</i></a>
                <a href="<?= base_url('courses/show/'.$c->id); ?>" class="float-end">VER MÁS <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </small>
        </div>
      </div>
    </div>
    <?php 
      endforeach; 
    endif; 
    ?>
    <?php
    if( !empty($posts)): 
      foreach ($posts as $p):
    ?>
    <div class="col-md-4 mb-4">
      <div class="card w-100 hvr-float">
        <div class="card-img-top card_header">
          <div class="position-absolute l-0 t-0 bg-danger py-1 px-4 rounded text-white top-0 start-0">BLOG</div>
          <img src="<?= base_url('uploads/blogs/'.$p->image); ?>" class="w-100 h-100 object-fit-cover" alt="...">
        </div>
        <div class="card-body position-relative">
          <div class="post_date position-absolute">
            <?php 
              $date = new DateTime($p->created_at);
              $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
              echo $formatter->format($date);
            ?>
          </div>
          <h5 class="card-title mt-3"><?= $p->title; ?></h5>
          <small>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-between mt-3">
                <a href="<?= base_url('user/user_save_wish?post_id='.$p->id); ?>" class="text-danger" onclick="return confirm('¿Está seguro de querer eliminar el post de favoritos?');"><i class="bi bi-heartbreak"></i> ELIMINAR</i></a>
                <a href="<?= base_url('blogs/show/'.$p->id); ?>" class="">VER MÁS <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </small>
        </div>
      </div>
    </div>
    <?php 
      endforeach; 
    endif; 

    if( empty($courses) && empty($posts) ):
    ?>
    <div class="col-12">
      <div class="alert alert-info" role="alert">
        No tienes favoritos aún.
      </div>
    </div>
    <?php
    endif;
    ?>
  </div>

<?= $this->endSection() ?>