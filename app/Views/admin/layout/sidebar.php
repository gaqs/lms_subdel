<?php $uri = service('uri'); ?>
<div id="sidebar" class="collapse collapse-horizontal show bg-dark text-white">
    <div id="sidebar-nav" class="d-flex flex-column border-0 rounded-0 text-sm-start min-vh-100">
        <div class="bg-dark text-white border-bottom border-dark p-3">
            <h3>LMS ADMIN</h3>
        </div>
        <ul class="nav nav-pills flex-column p-3 mb-auto">
            <li class="nav-item">
                <a href="<?= base_url('admin/users');?>" class="nav-link p-3 text-white <?= ($uri->getSegment(2) == 'users' ? 'active' : '') ?>">
                    <i class="bi bi-person me-2"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/blogs');?>" class="nav-link p-3 text-white <?= ($uri->getSegment(2) == 'blogs' ? 'active' : '') ?>">
                    <i class="bi bi-chat-square-quote me-2"></i> Blog
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/courses');?>" class="nav-link p-3 text-white <?= ($uri->getSegment(2) == 'courses' ? 'active' : '') ?>">
                    <i class="bi bi-journal-text me-2"></i> Cursos
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/admin');?>" class="nav-link p-3 text-white <?= ($uri->getSegment(2) == 'admin' ? 'active' : '') ?>">
                    <i class="bi bi-person-fill-gear me-2"></i> Administradores
                </a>
            </li>
        </ul>
        
    </div>
</div>