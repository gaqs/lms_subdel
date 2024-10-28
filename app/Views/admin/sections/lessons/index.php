<?php if(isset($course)): ?>
<div class="row">
	<div class="col-md-12 mb-3">
		<a href="<?= base_url('admin/module/new?course_id='.$course->id) ?>" class="btn btn-success" id="create_module" >Agregar Módulo <i class="bi bi-plus"></i></a>
	</div>
	<div class="col-md-12">
		<div class="row justify-content-center">
			<div class="col-md-12">

			<?php $count_m=1; if(isset($module)): foreach($module as $m): ?>

			<!-- module and lessons -->
			<div class="card mb-4">
				<div class="card-body" id="module_container">
					<div class="d-flex mb-4" id="module_header">
						<div class="me-auto" id="module_title"> Módulo <?= $count_m ?>: <?= $m->title ?></div>
						<div id="module_buttons">
							<a href="<?= base_url('admin/lesson/new?course_id='.$course->id.'&module_id='.$m->id) ?>" class="btn btn-outline-success" id="create_lesson">Agregar Lección <i class="bi bi-plus"></i></a>
							<div id="module_options" class="dropdown d-inline-block">
								<button class="btn btn-outline-success dropdown-toggle no_arrow" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li><a href="<?= base_url('admin/module/edit/'.$m->id) ?>" class="dropdown-item" id="edit_module">Editar</a></li>

									<li>
										<form action="<?= base_url('admin/module/delete') ?>" method="POST" class="">
											<input type="hidden" name="id" value="<?= $m->id ?>">
											<button type="submit" class="dropdown-item" onclick="return confirm('¿Está seguro de querer eliminar el módulo? Se eliminarán las lecciones asociadas a este módulo.');">
												Eliminar
											</button>            
										</form>
									</li>
								</ul>
							</div>
							<button class="btn btn-outline-success"><i class="bi bi-arrows-move"></i></button>
						</div>
					</div>

					<?php $count_l = 1; if(isset($lessons)): foreach ($lessons[$m->id] as $lesson): ?>
					<div class="mb-4" id="lesson_container">
						<div class="card text-bg-light">
							<div class="card-body d-flex p-4">
								<div id="lesson_title" class="me-auto">Lección <?= $count_l; ?>: <?= $lesson->title ?></div>
								<div id="lesson_options" class="me-1 dropdown d-inline-block">
									<button class="btn btn-outline-secondary dropdown-toggle no_arrow" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li><a href="<?= base_url('admin/lesson/edit/'.$lesson->id) ?>" class="dropdown-item">Editar</a></li>
										<li>
											<form action="<?= base_url('admin/lesson/delete') ?>" method="POST">
												<input type="hidden" name="id" value="<?= $lesson->id ?>">
												<button type="submit" class="dropdown-item" onclick="return confirm('¿Está seguro de querer eliminar la lección?.');">
													Eliminar
												</button>            
											</form>
										</li>
									</ul>
								</div>
								<button id="lesson_move" class="btn btn-outline-secondary"><i class="bi bi-arrows-move"></i></button>
							</div>
						</div>
					</div>
					<?php $count_l++; endforeach; endif; ?>
			
				</div>
			</div>

			<?php $count_m++; endforeach; endif; ?>
			<!-- /Module and lessons -->

			</div>
		</div>
	</div>
</div>
<?php endif; ?>