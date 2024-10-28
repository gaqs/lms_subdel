<?= $this->extend('shield/sections/home') ?>

<?= $this->section('user_main') ?>

      <h5 class="card-title">Mi Perfil</h5>
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

      <form action="<?= base_url('user/update') ?>" method="POST">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="input-name" class="form-label fw-bold mb-1">Nombre</label>
            <input type="text" class="form-control" id="input-name" name="name" value="<?= old('name', $user->name ?? '') ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-lastname" class="form-label fw-bold mb-1">Apellido</label>
            <input type="text" class="form-control" id="input-lastname" name="lastname" value="<?= old('lastname', $user->lastname ?? '') ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-sex" class="form-label fw-bold mb-1">Sexo</label>
            <select class="form-select" name="sex" id="select-sex">
              <option value="" <?= $user->sex == "" ? 'selected' : '' ?> >Seleccione</optio>
              <option value="F" <?= $user->sex == "F" ? 'selected' : '' ?> >Femenino</option>
              <option value="M" <?= $user->sex == "M" ? 'selected' : '' ?> >Masculino</option>
              <option value="O" <?= $user->sex == "O" ? 'selected' : '' ?> >Otro</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-username" class="form-label fw-bold mb-1">RUT</label>
            <input type="text" class="form-control disabled" id="input-username" name="username" value="<?= old('username', $user->username ?? '') ?>" oninput="checkRut(this)" maxlength="10" autocomplete="off" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-email" class="form-label fw-bold mb-1">Correo</label>
            <input type="email" class="form-control disabled" id="input-email" name="email" value="<?= old('email', $user->email ?? '') ?>" readonly> 
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-phone" class="form-label fw-bold mb-1">Teléfono</label>
            <div class="input-group">
              <span class="input-group-text">+56 9</span>
              <input type="text" class="form-control" id="input-phone" name="phone" maxlength="8" value="<?= old('phone', $user->phone ?? '') ?>">
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="input-birthday" class="form-label fw-bold mb-1">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="input-birthday" name="birthday" value="<?= old('birthday', $user->birthday ?? '') ?>">
          </div>

          <div class="col-md-12 mt-3"> 
            <button type="submit" class="btn btn-success float-end"><i class="bi bi-floppy2"></i> Actualizar Perfil</button>
          </div>
        </div>

      </form>  

<?= $this->endSection() ?>