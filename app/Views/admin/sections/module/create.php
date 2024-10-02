<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Editar Cursos <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?= base_url('admin/courses') ?>">Cursos</a></li>
			<li class="breadcrumb-item"><a href="<?= base_url('admin/courses/new') ?>">Editar curso</a></li>
      <li class="breadcrumb-item active" aria-current="page">Crear módulo</li>
		</ol>
	</nav>

	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Crear Módulo</h5>
			<hr>

			<?php
			if (session('error') !== null) {
				showFlashMessage('error', session('error'));
			} elseif (session('errors') !== null) {
				showFlashMessage('error', implode('<br>', session('errors')));
			} elseif (session('success') !== null) {
				showFlashMessage('success', session('success'));
			}
			?>

      <?php if($action == 'edit'): ?>
      <form action="<?= base_url('admin/module/update') ?>" method="POST">
      <?php elseif($action == 'new'): ?>  
      <form action="<?= base_url('admin/module/create') ?>" method="POST">
      <?php endif ?>  

        <div class="container">
          <div class="row">
            <input type="hidden" name="course_id" id="course_id" value="<?= $module->course_id ?? '' ?>">
            <input type="hidden" name="module_id" id="module_id" value="<?= $module->id ?? '' ?>">
            <div class="col-md-9 mb-3">
              <label for="input-title" class="form-label fw-bold mb-1">Título</label>
              <input type="text" class="form-control" id="input-title" name="title" value="<?= old('title', $module->title ?? '') ?>">
            </div>
            <div class="col-md-3 mb-3">
              <label for="input-duration" class="form-label fw-bold mb-1">Duración</label>
              <input type="number" class="form-control" id="input-duration" name="duration" value="<?= old('duration', $module->duration ?? '') ?>">
            </div>
            <div class="col-md-12 mb-3">
              <label for="textarea-module_description" class="form-label fw-bold mb-1">Descripción</label>
              <textarea name="description" class="form-control" id="textarea-module_description" rows="5"><?= old('description', $module->description ?? '') ?></textarea>
            </div>
            <div class="col-md-12 mt-3">
              <button type="submit" class="btn btn-success float-end">
                <i class="bi bi-floppy2"></i> Guardar
              </button>
            </div>
          </div>
          
        </div>
      </form>
			
		</div>
	</div>
</div>
<?= $this->endSection() ?>

