<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-md-5">
        <div class="card col-12 col-md-10 box_shadow px-md-5 pt-md-5 pb-md-2  border border-0">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center text-success"><?= lang('Auth.register') ?></h4>

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

                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <!-- Nombre -->
                        <div class="mb-3 col-12 col-md-6">
                            <label for="floatingNameInput" class="form-label fw-semibold text-body-secondary">Nombres</label>
                            <input type="text" class="form-control p-15" id="floatingNameInput" name="name" inputmode="text" autocomplete="name" placeholder="Nombres" value="<?= old('name') ?>" required>
                        </div>

                        <!-- Apellido -->
                        <div class="mb-3 col-12 col-md-6">
                            <label for="floatingLastnameInput" class="form-label fw-semibold text-body-secondary">Apellidos</label>
                            <input type="text" class="form-control p-15" id="floatingLastnameInput" name="lastname" inputmode="text" autocomplete="lastname" placeholder="Apellidos" value="<?= old('lastname') ?>" required>
                        </div>

                        <!-- RUT -->
                        <div class="mb-3 col-12 col-md-4">
                            <label for="floatingUsernameInput" class="form-label fw-semibold text-body-secondary">RUT</label>
                            <input type="text" class="form-control p-15" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="RUT" value="<?= old('username') ?>" maxlength="10" oninput="checkRut(this)" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-12 col-md-8">
                            <label for="floatingEmailInput" class="form-label fw-semibold text-body-secondary"><?= lang('Auth.email') ?></label>
                            <input type="email" class="form-control p-15" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3 col-12 col-md-6">
                            <label for="floatingPasswordInput" class="form-label fw-semibold text-body-secondary"><?= lang('Auth.password') ?></label>
                            <input type="password" class="form-control p-15" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                        </div>

                        <!-- Password (Again) -->
                        <div class="mb-3 col-12 col-md-6">
                            <label for="floatingPasswordConfirmInput" class="form-label fw-semibold text-body-secondary">Repetir contraseña</label>
                            <input type="password" class="form-control p-15" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="Contraseña" required>
                        </div>

                        <div class="d-grid col-12 mx-auto m-3">
                            <button type="submit" class="btn btn-success btn-block w-100 submit_something"><?= lang('Auth.register') ?></button>
                        </div>

                        <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>

                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
