<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Blog <?= $this->endSection() ?>


<?= $this->section('main') ?>

<section id="posts" class="sections">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <h4 class="title">Todos los Posts</h4>
        <hr>
        
        <div class="row">
          <?php foreach ($posts as $p): ?>
          <div class="col-md-6 mb-4">
            <div class="card w-100 hvr-float">
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
          <?php endforeach; ?>
        </div>

        <?= $pager->links('res', 'bootstrap') ?>
        
    </div>

    <div class="col-md-3">
      <h4 class="title">Categorías</h4>
      <hr>
      <form action="<?= base_url('blogs'); ?>" method="GET">
        <ul style="list-style:none;">
          <li>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" value="0" id="categorycheck_0" name="cat[]" <?= (isset($_GET['cat']) && in_array(0, $_GET['cat'])) || !isset($_GET['cat']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="categorycheck_0">Todas las categorias</label>
            </div>
          </li>
          <?php foreach ($cat as $c): ?>
            <li class="mb-2">
              <input class="form-check-input" type="checkbox" value="<?= $c->id ?>" id="<?= 'categorycheck_'.$c->id ?>" name="cat[]" <?= (isset($_GET['cat']) && in_array($c->id, $_GET['cat'])) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="<?= 'categorycheck_'.$c->id ?>"><?= $c->name; ?></label>
            </li>
          <?php endforeach; ?>
        </ul>
        <button class="btn btn-success float-end" type="submit">Filtrar</button>
      </form>
    </div>

  </div>
</section>

<script>
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name="cat[]"]');
  const allCheckbox = document.getElementById('categorycheck_0');

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', (e) => {
      if (e.target.value !== '0' && e.target.checked) {
        allCheckbox.checked = false;
      } else if (e.target.value === '0' && e.target.checked) {
        checkboxes.forEach((otherCheckbox) => {
          if (otherCheckbox.value !== '0') {
            otherCheckbox.checked = false;
          }
        });
      }
    });
  });
</script>

<?= $this->endSection() ?>