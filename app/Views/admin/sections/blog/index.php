<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Admin/Blogs <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">
  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Posts</li>
    </ol>
  </nav>
  
  <div class="row">
    <div>
    <?php
      if (session('error') !== null) {
        showFlashMessage('error', session('error'));
      }elseif (session('errors') !== null) {
        showFlashMessage('error', implode('<br>', session('errors')));
      }elseif (session('success') !== null) {
        showFlashMessage('success', session('success'));
      }
    ?>
    </div>
    <a href="<?= base_url('admin/blogs/new')?>" class="btn btn-success w-auto ms-2 mb-3"><i class="bi bi-person-add"></i> Nuevo Post</a>
  </div>
  <table class="table table-striped w-100 text-left" id="users_table">
    <thead>
      <tr>
        <th class="align-middle text-start">ID</th>
        <th class="align-middle text-start">Titulo</th>
        <th class="align-middle text-start">Status</th>
        <th class="align-middle text-start">Autor</th>
        <th class="align-middle text-start">Creado</th>
        <th class="align-middle text-end" style="min-width:120px">Accion</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($posts as $p) { ?>
        <tr>
          <td class="align-middle text-start"><?= $p->id ?></td>
          <td class="align-middle text-start"><?= $p->title ?></td>
          <td class="align-middle text-start"><?= $p->status == 'publish' ? 'Publicado' : 'Borrador' ?></td>
          <td class="align-middel text-start"><?= $p->name.' '.$p->lastname ?></td>
          <td class="align-middle text-start"><?= $p->created_at ?></td>
          <td class="align-middle text-end">
            <a href="<?= base_url('admin/blogs/edit/'.$p->id); ?>" type="button" class="btn btn-primary d-inlne-block">
              <i class="bi bi-pencil-square"></i>
            </a>
            <form action="<?= base_url('admin/blogs/delete') ?>" method="POST" class="d-inline">
              <!--<input type="hidden" name="_method" value="DELETE">-->
              <input type="hidden" name="id" value="<?= $p->id ?>">
              <button type="submit" class="btn btn-danger rounded-end" onclick="return confirm('¿Está seguro de querer eliminar el post?');">
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

