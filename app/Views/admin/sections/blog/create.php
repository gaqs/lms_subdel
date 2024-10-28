<?= $this->extend('admin/layout/app') ?>

<?= $this->section('title') ?>Editar Posts <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container mt-4">
    
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin/blogs') ?>">Posts</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar Post</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Editar Post</h5>
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

      <?php if($action == 'edit'): ?>
      <form action="<?= base_url('admin/blogs/update') ?>" method="POST" enctype="multipart/form-data">

      <?php elseif($action == 'new'): ?>  
      <form action="<?= base_url('admin/blogs/create') ?>" method="POST" enctype="multipart/form-data">

      <?php endif ?>  

        <div class="row">
          <input type="hidden" name="id" value="<?= old('id', $post->id ?? '') ?>">
          <div class="col-md-10 mb-3">
            <div class="form-check form-switch">
              <?php
                $checked = '';
                if(isset($post)){ if($post->status == 'publish'){ $checked = 'checked'; } }
              ?>
              <input class="form-check-input" type="checkbox" role="switch" name="publish" id="input-switch" <?= $checked; ?>>
              <label class="form-check-label" for="input-switch">Publicar</label>
            </div>
          </div>
          <div class="col-md-8 mb-3">
            <label for="input-title" class="form-label fw-bold mb-1">Titulo</label>
            <input type="text" class="form-control" id="input-title" name="title" value="<?= old('title', $post->title ?? '') ?>">
          </div>
          <div class="col-md-4 mb-3">
            <label for="input-category" class="form-label fw-bold mb-1">Categoria</label>
            <select class="form-select" aria-label="Default select example" name="category">
              <?= category_list(old('title', $post->category_id ?? '')); ?>
            </select>
          </div>

          <div class="col-md-12 mb-3">
            <label for="input-file" class="form-label fw-bold mb-1">Imagen header</label>
            <input type="hidden" name="image_name" value="<?= $post->image ?? '' ?>">
            <input type="file" class="form-control" id="input-file" name="image">
          
            <?php  if( !empty($post->image) ): ?>
                <div class="file_container position-relative mt-3" style="width:30%;">
                  <a href="<?= base_url('admin/blogs/delete_media?id='.$post->id.'&type=image'); ?>" class="text-danger position-absolute end-0 delete_button"  onclick="return confirm('¿Está seguro de querer eliminar el video?');">
                    <i class="bi bi-trash"></i>
                  </a>
                  <img src="<?=base_url('public/uploads/blogs/'.$post->image) ?>" class="w-100">
                </div>
            <?php endif ?>

          </div>
          
          <div class="col-md-12 mb-3">
            <label for="textarea-description" class="form-label fw-bold mb-1">Descripcion</label>
            <textarea class="form-control" id="textarea-description" name="description"><?= old('description', $post->description ?? '') ?></textarea>
          </div>

          <div class="col-md-6">
            <label for="input-category" class="form-label fw-bold mb-1">Archivo adjunto (.mp4 o .pdf)</label>
            <input type="hidden" name="file_name" value="<?= $post->file ?? '' ?>">
            <input type="file" class="form-control" id="video_file" name="file">

            <?php  
              if( !empty($post->file) ):
                $ext = strtolower( substr( $post->file, -4));
                if($ext == '.mp4'):
            ?>
                <div class="file_container position-relative mt-3">
                  <a href="<?= base_url('admin/home/delete_media?id='.$post->id.'&type=file&folder=blogs'); ?>" class="text-danger position-absolute end-0 delete_button"  onclick="return confirm('¿Está seguro de querer eliminar el video?');">
                    <i class="bi bi-trash"></i>
                  </a>
                  <video class="video-js mt-4 w-100 h-100" controls>
                    <source src="<?= base_url('public/uploads/blogs/'.$post->file) ?>" type="video/mp4">
                  </video>
                </div>
            
            <?php elseif($ext == '.pdf'):?>
              <div class="file_container position-relative mt-3">
                <a href="<?= base_url('admin/home/delete_media?id='.$post->id.'&type=file&folder=blogs'); ?>" class="text-danger position-absolute end-0 delete_button"  onclick="return confirm('¿Está seguro de querer eliminar el video?');">
                  <i class="bi bi-trash"></i>
                </a>

                <embed src="<?= base_url('public/uploads/blogs/'.$post->file) ?>" type="application/pdf" height="500" style="width:100%;">

              </div>
            <?php 
                endif;
              endif 
            ?>

          </div>
        
          <div class="col-md-6 mb-3">
            <label for="input-keywords" class="form-label fw-bold mb-1">Keywords</label>
            <input type="text" class="form-control" id="input-keywords" name="keywords" value="<?= old('keywords', $post->keywords ?? '') ?>">
          </div>

          <div class="col-md-12 mt-3"> 
            <button type="submit" class="btn btn-success float-end"><i class="bi bi-floppy2"></i> Guardar</button>
          </div>
        </div>
      </form>  

    </div>
  </div>
</div>

<?= $this->endSection() ?>