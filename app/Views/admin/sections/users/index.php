<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Admin/Usuarios <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">
  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
    </ol>
  </nav>
  
  <div class="row">
    <a href="<?= base_url('admin/users/new')?>" class="btn btn-success w-auto ms-2 mb-3"><i class="bi bi-person-add"></i> Agregar Usuario</a>
  </div>
  <table class="table table-striped w-100 text-left" id="users_table">
    <thead>
      <tr>
        <th class="align-middle text-start">ID</th>
        <th class="align-middle text-start">Nombre</th>
        <th class="align-middle text-start">Apellido</th>
        <th class="align-middle text-start">RUT</th>
        <th class="align-middle text-start">Correo</th>
        <th class="align-middle text-end">Creado</th>
        <th class="align-middle text-end" style="min-width:120px">Accion</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u) { ?>
        <tr>
          <td class="align-middle text-start"><?= $u->id ?></td>
          <td class="align-middle text-start"><?= $u->name ?></td>
          <td class="align-middle text-start"><?= $u->lastname ?></td>
          <td class="align-middle text-start"><?= $u->username ?></td>
          <td class="align-middle text-start"><?= $u->email ?></td>
          <td class="align-middle text-end"><?= $u->created_at ?></td>
          <td class="align-middle text-end">
            <a href="<?= base_url('admin/users/edit/'.$u->id); ?>" type="button" class="btn btn-primary d-inline-block">
              <i class="bi bi-pencil-square"></i>
            </a>
            <form action="<?= base_url('admin/users/delete') ?>" method="POST" class="d-inline">
              <input type="hidden" name="id" value="<?= $u->id ?>">
              <button type="submit" class="btn btn-danger rounded-end" onclick="return confirm('¿Está seguro de querer eliminar al usuario?');">
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

