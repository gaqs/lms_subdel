<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Iniciar Sesión <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-md-5">
        <div class="card col-12 col-md-6 box_shadow px-md-5 pt-md-5 pb-md-2  border border-0">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center text-success"><?= lang('Auth.login') ?></h4>

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

                <?php if (session('message') !== null) : ?>
                <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                <?php endif ?>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="floatingEmailInput" class="form-label fw-semibold text-body-secondary"><?= lang('Auth.email') ?></label>
                        <input type="email" class="form-control p-15" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="floatingPasswordInput" class="form-label fw-semibold text-body-secondary"><?= lang('Auth.password') ?></label>
                        <input type="password" class="form-control p-15" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                    </div>

                    <!-- Remember me -->
                    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="formCheckInput" name="remember" <?php if (old('remember')): ?> checked <?php endif ?>>
                            <label class="form-check-label" for="formCheckInput">
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>

                    <?php endif; ?>

                    <div class="d-grid col-12 mx-auto m-3">
                        <button type="submit" class="btn btn-success btn-block"><?= lang('Auth.login') ?></button>
                    </div>

                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <p class="text-center"><?= lang('Auth.forgotPassword') ?><br><a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
                    <?php endif ?>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                    <?php endif ?>

                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
