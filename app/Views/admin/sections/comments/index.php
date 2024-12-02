<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Admin/Comentarios <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">
  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Comentarios</li>
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
  </div>
  <div class="row">
  <table class="table table-striped w-100 text-left" id="users_table">
    <thead>
      <tr>
        <th class="align-middle text-start">ID</th>
        <th class="align-middle text-start">Fecha</th>
        <th class="align-middle text-start">Responsable</th>
        <th class="align-middle text-start">Comentario</th>
        <th class="align-middle text-start">Sección</th>
        <th class="align-middle text-end" style="min-width:120px">Accion</th> <!-- ?!?!?!??!?! WHYYYYYY-->
      </tr>
    </thead>
    <tbody>
      <?php foreach ($comments as $c): ?>
        <tr>
          <td class="align-middle text-start"><?= $c->id ?></td>
          <td class="align-middle text-start"><?= $c->created_at ?></td>
          <td class="align-middle text-start"><?= $c->commentator ?></td>
          <td class="align-middel text-start"><?= $c->comment ?></td>
          <td class="align-middle text-start">
          <?php
            if( $c->section != '' ){
              echo $c->section.'/'.$c->section_id;
            }else{
              echo $comments[$c->parent_comment_id]->section.'/'.$comments[$c->parent_comment_id]->section_id;
            }
          ?>
          </td>
          <td class="align-middle text-end">
            <a href="<?= base_url($c->section.'/show/'.$c->section_id.'#comment-'.$c->id) ?>" type="button" class="btn btn-success d-inline-block">
              <i class="bi bi-box-arrow-in-right"></i>
            </a>
            <a href="<?= base_url('admin/comments/delete?comment_id='.$c->id) ?>" type="button" class="btn btn-danger d-inline" onclick="return confirm('¿Está seguro de querer eliminar el comentario?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      
    </tbody>
  </table>
  </div>

</div>

<?= $this->endSection() ?>

