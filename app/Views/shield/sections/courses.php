<?= $this->extend('shield/sections/home') ?>
<?= $this->section('user_main') ?>

<h5 class="card-title">Mis cursos</h5>
  <hr>
  
  <div class="row">
    <?php foreach ($courses as $c): ?>
    <div class="col-md-6 mb-4">
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
          <small>
            <div class="row">
              <div class="col">
                <i class="bi bi-person"></i> Por <?= $c->name.' '.$c->lastname; ?>
              </div>
              <div class="col">
                <a href="<?= base_url('lesson/show/'.$c->first); ?>" class="float-end">CONTINUAR <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </small>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

<?= $this->endSection() ?>