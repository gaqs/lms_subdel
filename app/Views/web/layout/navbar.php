<?php $uri = service('uri'); ?>
<nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary py-3">
  <div class="container">
    <a class="navbar-brand me-5" href="<?= base_url(); ?>" ><i class="bi bi-mortarboard-fill text-success fs-3"></i> <b class="text-dark fw-bold">LMS</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-md-2 text-dark <?= ($uri->getSegment(1) == '' ? 'hvr_underline' : 'hvr-underline-from-left') ?>" aria-current="page" href="<?= base_url(); ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-md-2 text-dark <?= ($uri->getSegment(1) == 'blogs' ? 'hvr_underline' : 'hvr-underline-from-left') ?>" aria-current="page" href="<?= base_url('blogs'); ?>">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-md-2 text-dark <?= ($uri->getSegment(1) == 'courses' ? 'hvr_underline' : 'hvr-underline-from-left') ?>" aria-current="page" href="<?= base_url('courses'); ?>">Cursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-md-2 text-dark disabled <?= ($uri->getSegment(1) == 'instructors' ? 'hvr_underline' : 'hvr-underline-from-left') ?>" aria-current="page" href="#">Instructores</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        <?php if( !isset(auth()->user()->username) ): ?>

        <a href="<?= url_to('login') ?>" class="btn btn-success"> <i class="bi bi-person"></i> Iniciar Sesión</a>
        <a href="<?= url_to('register') ?>" class="btn btn-link"> <i class="bi bi-person-plus"></i> Registrarse</a>
        
        <?php else: ?>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= auth()->user()->name.' '.auth()->user()->lastname; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('user');?>">Mi Perfil</a></li>
            <li><a class="dropdown-item" href="<?= base_url('logout');?>">Desconectar</a></li>
            <?php if(auth()->user()->can('admin.access')): ?>
            <li>
              <hr>
              <a class="dropdown-item" href="<?= base_url('admin');?>">Administrador</a>
            </li>
            <?php endif ?>
          </ul>
        </div>
        <?php endif; ?>
      </ul>
      
      
    </div>
    
  </div>
</nav>