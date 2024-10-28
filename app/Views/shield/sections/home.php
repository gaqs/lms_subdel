<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Mi Perfil<?= $this->endSection() ?>

<?= $this->section('main') ?>

<section id="course_start" class="pt-2">
  <div class="container text-white">

      <div class="row mt-5">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="profile_card text-center">
                <div class="profile_cover"></div>
                <div class="profile_info">
                  <div class="profile_initial d-flex justify-content-center">
                    <div class="letter uppercase"><?= substr(auth()->user()->name,0,1) ?></div>
                  </div>
                  <h4><?= auth()->user()->name.' '.auth()->user()->lastname ?></h4>
                  <p><?= auth()->user()->email ?></p>
                </div>
              </div>
              <div class="profile_menu px-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item mt-2 pb-3">
                    <a href="<?= base_url('user');?>"><i class="bi bi-person"></i> Mi perfil</li></a>
                  <li class="list-group-item mt-2 pb-3">
                    <a href="<?= base_url('user/courses');?>"><i class="bi bi-journal-bookmark-fill"></i> Cursos</li></a>
                  <li class="list-group-item mt-2 pb-3">
                    <a href="<?= base_url('user/wishlist');?>"><i class="bi bi-suit-heart"></i> Favoritos</li></a>
                  <li class="list-group-item mt-2 pb-3">
                    <a href="<?= base_url('user/password');?>"><i class="bi bi-gear"></i> Contraseña</li></a>
                  <li class="list-group-item mt-2 pb-3">
                    <a href="<?= base_url('logout');?>"><i class="bi bi-box-arrow-right"></i> Logout</li></a>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card border-0">
            <div class="card-body pt-0">
              <?= $this->renderSection('user_main') ?>
            </div>
          </div>
        </div>

      </div>

  </div>
</section>

<?= $this->endSection() ?>