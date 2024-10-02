<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Blog <?= $this->endSection() ?>


<?= $this->section('main') ?>

<section id="post">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <small>
        <i class="bi bi-calendar-event"></i>
        <?php 
          $date = new DateTime($post->created_at);
          $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
          echo $formatter->format($date);
        ?> 
        | por <?= $post->name.' '.$post->lastname; ?>
        </small>
        <hr>
        <div class="card_header rounded">
          <img src="<?= base_url('uploads/blog/'.$post->image); ?>" class="w-100 h-100 object-fit-cover" alt="...">
        </div>
        <h2 class="mt-3"><?= $post->title; ?></h2>
        <div class="ms-5"><?= $post->description; ?></div>

        <?php  if( !empty($post->file) ): ?>
        <div class="position-relative mt-3 mb-5">
          <video class="video-js mt-4 w-100" controls>
            <source src="<?=base_url('public/uploads/blog/'.$post->file) ?>" type="video/mp4">
          </video>
        </div>
        <?php endif ?>

      </div>
      <div class="col-md-4">
        <small class="fw-bold">Quizás te interese</small>
        <hr>
        <div class="row">
          <?php foreach ($posts as $p){?>
          <div class="col-md-12 mb-4">
            <div class="card w-100">
              <div class="card-img-top card_header">
                <img src="<?= base_url('uploads/blog/'.$p->image); ?>" class="w-100 h-100 object-fit-cover" alt="...">
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
                <p class="card-text">
                  <?= substr( $p->description, 0, 100).'...'; ?>
                </p>
                <small>
                  <div class="row">
                    <div class="col">
                      <i class="bi bi-person"></i> Por <?= $p->name.' '.$p->lastname; ?>
                    </div>
                    <div class="col">
                      <a href="<?= base_url('blogs/show/'.$p->id); ?>" class="float-end">SEGUIR LEYENDO <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </small>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        
      </div>
    </div>
  </div>
</section>


<?= $this->endSection() ?>