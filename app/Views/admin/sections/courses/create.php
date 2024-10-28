<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Editar Cursos <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?= base_url('admin/courses') ?>">Cursos</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?= ($action == 'new') ? 'Crear' : 'Editar' ?> curso</li>
		</ol>
	</nav>

	<div class="card">
		<div class="card-body">
			<h5 class="card-title"><?= ($action == 'new') ? 'Crear' : 'Editar' ?>  curso</h5>
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

			<!-- Datos Basicos -->
			<?php if ($action == 'edit'): ?>
			<form action="<?= base_url('admin/courses/update') ?>" method="POST" enctype="multipart/form-data">
			<?php elseif ($action == 'new'): ?>
			<form action="<?= base_url('admin/courses/create') ?>" method="POST" enctype="multipart/form-data">
			<?php endif ?>
				<div class="row">
					<div class="col-md-12">
						<ul class="nav nav-underline justify-content-center" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="basic_link" aria-current="page" href="#basic_tab" data-bs-toggle="tab" data-bs-target="#basic_tab" role="presentation" aria-controls="basic_tab" aria-selected="true">
									<i class="bi bi-1-circle"></i> Datos Básicos <i class="bi bi-chevron-right"></i>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?= ($action == 'new') ? 'disabled' : '' ?> " id="lessons_link" aria-current="page" href="#lesson_tab" data-bs-toggle="tab" data-bs-target="#lessons_tab" role="presentation"  aria-controls="lessons_tab" aria-selected="true">
									<i class="bi bi-2-circle"></i> Lecciones
								</a>
							</li>
						</ul>

						<div class="tab-content" id="courses_tabs">
							<div class="tab-pane show active" id="basic_tab" role="tabpanel" aria-labelledby="basic_tab" tabindex="0">

								<div class="row">
									<input type="hidden" name="course_id" value="<?= old('id', $course->id ?? '') ?>">
									<div class="col-md-10 mb-3">
										<div class="form-check form-switch">
											<?php
											$checked = '';
											if (isset($course)) {
												if ($course->status == 'publish') {
													$checked = 'checked';
												}
											}
											?>
											<input class="form-check-input" type="checkbox" role="switch" name="publish" id="input-switch" <?= $checked; ?>>
											<label class="form-check-label" for="input-switch">Publicar</label>
										</div>
									</div>
									<div class="col-md-8 mb-3">
										<label for="input-title" class="form-label fw-bold mb-1">Titulo</label>
										<input type="text" class="form-control" id="input-title" name="title" value="<?= old('title', $course->title ?? '') ?>">
									</div>
									<div class="col-md-4 mb-3">
										<label for="select-category" class="form-label fw-bold mb-1">Categoria</label>
										<select class="form-select" aria-label="Default select example" name="category" id="select-category">
											<?= category_list(old('category', $course->category_id ?? '')); ?>
										</select>
									</div>
									<div class="col-md-9 mb-3">
										<label for="input-resume" class="form-label fw-bold mb-1">Resumen</label>
										<input type="text" class="form-control" id="input-resume" name="resume" value="<?= old('resume', $course->resume ?? '') ?>">
									</div>
									<div class="col-md-3 mb-3">
										<label for="select-level" class="form-label fw-bold mb-1">Nivel</label>
										<select class="form-select" aria-label="Default select example" name="level" id="select-level">
											<?= levels_list(old('level', $course->level_id ?? '')); ?>
										</select>
									</div>
									<div class="col-md-12 mb-3">
										<label for="input-file" class="form-label fw-bold mb-1">Imagen header</label>
										<input type="hidden" name="image_name" value="<?= $course->image ?? '' ?>">
										<input type="file" class="form-control" id="input-file" name="image">

										<?php if (!empty($course->image)): ?>
											<div class="file_container position-relative mt-3" style="width:50%;">
												<a href="<?= base_url('admin/home/delete_media?id=' . $course->id . '&type=image&folder=courses'); ?>" class="text-danger position-absolute end-0 delete_button" onclick="return confirm('¿Está seguro de querer eliminar el video?');">
													<i class="bi bi-trash"></i>
												</a>
												<img src="<?= base_url('public/uploads/courses/' . $course->image) ?>" class="w-100">
											</div>
										<?php endif ?>

									</div>


									<div class="col-md-12 mb-3">
										<label for="textarea-description" class="form-label fw-bold mb-1">Descripcion</label>
										<textarea class="form-control" id="textarea-description" name="description"><?= old('description', $course->description ?? '') ?></textarea>
									</div>

									<div class="col-md-6 mb-3">
										<label for="input-keywords" class="form-label fw-bold mb-1">Keywords</label>
										<input type="text" class="form-control" id="input-keywords" name="keywords" value="<?= old('keywords', $course->keywords ?? '') ?>">
									</div>
									
								</div>
								
								<!-- Fin Datos Basicos -->

							</div>

							<div class="tab-pane" id="lessons_tab" role="tabpanel" aria-labelledby="lessons_tab" tabindex="0">

								<?= $this->include('admin/sections/lessons/index') ?>
 
							</div>

						</div>
					</div>
					<div class="col-md-12 mt-3">
						<button type="submit" class="btn btn-success float-end">
							<i class="bi bi-floppy2"></i> Guardar
						</button>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>
<?= $this->endSection() ?>