<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Editar Cursos <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?= base_url('admin/courses') ?>">Cursos</a></li>
			<li class="breadcrumb-item"><a href="<?= base_url('admin/courses/edit') ?>">Editar Curso</a></li>
      <li class="breadcrumb-item active" aria-current="page">Crear Lección</li>
		</ol>
	</nav>

	<div class="card mb-4">
		<div class="card-body">
			<h5 class="card-title">Crear Lección</h5>
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
      <form action="<?= base_url('admin/lesson/update') ?>" method="POST" enctype="multipart/form-data">
      <?php elseif($action == 'new'): ?>  
      <form action="<?= base_url('admin/lesson/create') ?>" method="POST" enctype="multipart/form-data">
      <?php endif ?>  

        <div class="container">
          <div class="row">
            <input type="hidden" id="module_id" name="module_id" value="<?= $lesson->module_id ?? '' ?>">
            <input type="hidden" name="lesson_id" id="lesson_id" value="<?= $lesson->id ?? '' ?>">
            <div class="col-md-12 mb-3">
              <label for="input-title" class="form-label fw-bold mb-1">Título</label>
              <input type="text" class="form-control" id="input-title" name="title" value="<?= old('title', $lesson->title ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
              <label for="input-duration" class="form-label fw-bold mb-1">Duración</label>
              <input type="number" class="form-control" id="input-duration" name="duration" value="<?= old('duration', $lesson->duration ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
              <label for="input-keywords" class="form-label fw-bold mb-1">Keywords</label>
              <input type="text" class="form-control" id="input-keywords" name="keywords" value="<?= old('keywords', $lesson->keywords ?? '') ?>">
            </div>
            <div class="col-md-12 mb-3">
              <label for="textarea-lesson" class="form-label fw-bold mb-1">Descripción</label>
              <textarea name="description" class="form-control" id="textarea-lesson" rows="5"><?= old('description', $lesson->description ?? '') ?></textarea>
            </div>
            <div class="col-md-12">
              <label for="input-category" class="form-label fw-bold mb-1">Archivo adjunto (.mp4 o .pdf)</label>
              <input type="hidden" name="file_name" value="<?= $lesson->file ?? '' ?>">
              <input type="file" class="form-control" id="video_file" name="file" accept="application/pdf, video/mp4">

              <?php  
                if( !empty($lesson->file) ):
                  $ext = strtolower( substr( $lesson->file, -4));
                  if($ext == '.mp4'):
              ?>
                  <div class="file_container position-relative mt-3">
                    <a href="<?= base_url('admin/blogs/delete_file?id='.$lesson->id.'&filename='.$lesson->file); ?>" class="text-danger position-absolute end-0 delete_button"  onclick="return confirm('¿Está seguro de querer eliminar el video?');">
                      <i class="bi bi-trash"></i>
                    </a>
                    <video class="video-js mt-4" controls>
                      <source src="<?=base_url('public/uploads/lesson/'.$lesson->file) ?>" type="video/mp4">
                    </video>
                  </div>
              
              <?php elseif($ext == '.pdf'):?>
                <div class="file_container position-relative mt-3">
                  <a href="<?= base_url('admin/blogs/delete_file?id='.$lesson->id.'&filename='.$lesson->file); ?>" class="text-danger position-absolute end-0 delete_button"  onclick="return confirm('¿Está seguro de querer eliminar el video?');">
                    <i class="bi bi-trash"></i>
                  </a>
                  <a href="<?=base_url('public/uploads/lesson/'.$lesson->file) ?>">
                    <i class="bi bi-filetype-pdf"></i>
                  </a>
                </div>
              <?php 
                  endif;
                endif 
              ?>

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

