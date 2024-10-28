<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse" class="navbar-brand border rounded-3 p-1 text-decoration-none">
      <i class="bi bi-list"></i> Menu
    </a>
    <div class="dropdown p-3">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <?= auth()->user()->name.' '.auth()->user()->lastname; ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li>
          <a class="dropdown-item" href="<?= base_url('user');?>">Profile</a>
        </li>
        <li>
          <a class="dropdown-item" href="<?= base_url('logout');?>">Desconectar</a>
        </li>
        <?php if(auth()->user()->can('admin.access')): ?>
        <li>
          <hr>
          <a class="dropdown-item" href="<?= base_url('admin');?>">Administrador</a>
        </li>
        <?php endif ?>
      </ul>
    </div>
  </div>
</nav>

