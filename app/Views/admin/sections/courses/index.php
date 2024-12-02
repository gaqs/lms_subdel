<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Admin/Cursos <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cursos</li>
        </ol>
    </nav>

    <div class="row">
        <div>
            <?php
            if (session('error') !== null) {
                showFlashMessage('error', session('error'));
            } elseif (session('errors') !== null) {
                showFlashMessage('error', implode('<br>', session('errors')));
            } elseif (session('success') !== null) {
                showFlashMessage('success', session('success'));
            }
            ?>
        </div>
        <a href="<?= base_url('admin/courses/new') ?>" class="btn btn-success w-auto ms-2 mb-3" id="new_course">
            <i class="bi bi-person-add"></i> Nuevo Curso
        </a>
    </div>
    <table class="table table-striped w-100 text-left" id="users_table">
        <thead>
            <tr>
                <th class="align-middle text-start">ID</th>
                <th class="align-middle text-start">Titulo</th>
                <th class="align-middle text-start">Status</th>
                <th class="align-middle text-start">Instructor</th>
                <th class="align-middle text-start">Creado</th>
                <th class="align-middle text-end" style="min-width:120px">Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $c) { ?>
                <tr>
                    <td class="align-middle text-start"><?= $c->id; ?></td>
                    <td class="align-middle text-start"><?= $c->title; ?></td>
                    <td class="align-middle text-start"><?= $c->status == 'publish' ? 'Publicado' : 'Borrador' ?> </td>
                    <td class="align-middel text-start"><?= $c->username.' '.$c->userlastname; ?></td>
                    <td class="align-middle text-start"><?= $c->created_at; ?></td>
                    <td class="align-middle text-end">
                        <a href="<?= base_url('admin/courses/edit/' . $c->id); ?>" type="button" class="btn btn-primary d-inline-block" id="edit_course">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="<?= base_url('admin/courses/delete') ?>" method="POST" class="d-inline">
                            <!--<input type="hidden" name="_method" value="DELETE">-->
                            <input type="hidden" name="id" value="<?= $c->id ?>">
                            <button type="submit" class="btn btn-danger rounded-end" onclick="return confirm('¿Está seguro de querer eliminar el curso?');">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>