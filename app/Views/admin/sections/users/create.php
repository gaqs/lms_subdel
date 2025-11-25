<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Editar Usuario <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">
    
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Usuarios</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Editar Usuario</h5>
      <hr>
      
      <?php
      if (session('error') !== null) {
        showFlashMessage('error', session('error'));
      }elseif (session('errors') !== null) {
        showFlashMessage('error', implode('<br>', session('errors')));
      }elseif (session('success') !== null) {
        showFlashMessage('success', session('success'));
      }
      ?>

      <?php if($action == 'edit'): ?>
      <form action="<?= base_url('admin/users/update') ?>" method="POST">

      <?php elseif($action == 'new'): ?>  
      <form action="<?= base_url('admin/users/create') ?>" method="POST">

      <?php endif ?>  

        <div class="row">
          <input type="hidden" name="id" value="<?= old('id', $user->id ?? '') ?>">
          <div class="col-md-6 mb-3">
            <label for="input-name" class="form-label fw-bold mb-1">Nombre</label>
            <input type="text" class="form-control" id="input-name" name="name" value="<?= old('name', $user->name ?? '') ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-lastname" class="form-label fw-bold mb-1">Apellido</label>
            <input type="text" class="form-control" id="input-lastname" name="lastname" value="<?= old('lastname', $user->lastname ?? '') ?>">
          </div>
          <div class="col-md-5 mb-3">
            <label for="input-username" class="form-label fw-bold mb-1">RUT</label>
            <input type="text" class="form-control" id="input-username" name="username" value="<?= old('username', $user->username ?? '') ?>" oninput="checkRut(this)" maxlength="10" autocomplete="off">
          </div>
          <div class="col-md-7 mb-3">
            <label for="input-email" class="form-label fw-bold mb-1">Correo</label>
            <div class="input-group">
              <input type="email" class="form-control" id="input-email" name="email" value="<?= old('email', $user->email ?? '') ?>">
              <span class="input-group-text" id="validado">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" name="validated" id="input-switch" <?= isset($user) ? $user->active == 1 ? 'checked' : '' : '' ?>>
                  <label class="form-check-label" for="input-switch">Validado?</label>
                </div>
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <label for="input-password" class="form-label fw-bold mb-1">Contraseña</label>
            <input type="text" class="form-control" id="input-password" name="password" value="<?= old('password', $user->password ?? '') ?>">
            <small class="text-secondary">Dejar en blanco si <b>no</b> desea cambiar la contraseña</small>
          </div>

          <?php if( auth()->user()->inGroup('admin', 'superadmin') ): ?>
          <div class="col-md-6 d-flex align-items-center">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="admin-switch" name="admin" <?= isset($user) ? $user->admin == true ? 'checked' : '' : '' ?>>
              <label class="form-check-label" for="admin-switch">Dar permisos administrativos</label>
            </div>
          </div>
          <?php endif ?>
          
          <div class="row">
            <div class="col-md-12">

            <h5 class="card-title mt-4">Cursos</h5>
            <hr>
            <!-- lista de cursos tomados por el usuario -->
            <ul class="lh-lg">
              <?php 
              if( empty($courses) ){
                echo '<li><i>El usuario no ha tomado ningún curso aún.</i></li>';
              }else{
                foreach ($courses as $count => $course) {
                  $complete = $course->complete == 1 ? '[Completado]' : '[En progreso]';
                  echo '<li><a href="'.base_url('courses/show/').$course->course_id.'" target="_blank">'.$course->title.'</a> '.$complete.'</li>';
                }
              }
              ?>
            </ul>

            </div>
          </div>
          
          <div class="col-md-12 mt-3"> 
            <button type="submit" class="btn btn-success float-end"><i class="bi bi-floppy2"></i> Guardar</button>
          </div>
        </div>
      </form>  

      

    </div>
  </div>



</div>

<?= $this->endSection() ?>