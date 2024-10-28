<?= $this->extend('shield/sections/home') ?>
<?= $this->section('user_main') ?>

<h5 class="card-title">Cambiar contraseña</h5>
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

  <form action="<?= base_url('user/change_password') ?>" method="POST">

    <div class="row justify-content-md-center">
      <!--<input type="hidden" name="id" value="<?= old('id', $user->id ?? '') ?>">-->
      <div class="col-md-8 mb-3">
        <label for="input-oldpass" class="form-label fw-bold mb-1">Contraseña antigua</label>
        <input type="password" class="form-control" id="input-oldpass" name="oldpass" value="<?= old('oldpass', $user->oldpass ?? '') ?>">
      </div>
      <div class="col-md-8 mb-3">
        <label for="input-newpass" class="form-label fw-bold mb-1">Nueva contraseña</label>
        <input type="password" class="form-control" id="input-newpass" name="newpass" value="<?= old('newpass', $user->newpass ?? '') ?>">
      </div>
      <div class="col-md-8 mb-3">
        <label for="input-repeatpass" class="form-label fw-bold mb-1">Repetir contraseña</label>
        <input type="password" class="form-control" id="input-repeatpass" name="repeatpass" value="<?= old('repeatpass', $user->repeatpass ?? '') ?>">
      </div>

      <div class="col-md-8 mt-3"> 
        <button type="submit" class="btn btn-success float-end"><i class="bi bi-floppy2"></i> Cambiar contraseña</button>
      </div>
    </div>

  </form>  

<?= $this->endSection() ?>