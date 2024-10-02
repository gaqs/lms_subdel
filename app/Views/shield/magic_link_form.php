<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-6 box_shadow px-md-5 pt-md-5 pb-md-2 border border-0">
        <div class="card-body">
            <h4 class="card-title mb-3 text-center text-success"><?= lang('Auth.useMagicLink') ?></h4>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>                            
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

            <form action="<?= url_to('magic-link') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-2">
                    <label class="form-label fw-semibold text-body-secondary" for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" autocomplete="email" placeholder="Ej. usuario@gmail.com" value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                </div>

                <div class="d-grid col-12 col-md-12 mx-auto m-3">
                    <button type="submit" class="btn btn-success btn-block w-100"><?= lang('Auth.send') ?></button>
                </div>

            </form>

            <p class="text-center"><a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
