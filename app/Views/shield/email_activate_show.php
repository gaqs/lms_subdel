<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.emailActivateTitle') ?></h5>

            <?php if (session('error')) : ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif ?>

            <p><?= lang('Auth.emailActivateBody') ?></p>

            <form action="<?= url_to('auth-action-verify') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Code -->
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingTokenInput" name="token" placeholder="000000" inputmode="numeric"
                        pattern="[0-9]*" autocomplete="one-time-code" value="<?= old('token') ?>" required>
                    <label for="floatingTokenInput">Código de activación</label>
                </div>

                <div class="d-flex justify-content-between col-12 mx-auto m-3">
                  <a href="<?= base_url('logout');?>" type="submit" class="btn btn-secondary btn-block">Desconectar</a>
                  <button type="submit" class="btn btn-success btn-block"><i class="bi bi-send"></i> <?= lang('Auth.send') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
