<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-md-5">
    <div class="card col-12 col-md-6 box_shadow px-md-5 pt-md-5 pb-md-2  border border-0">
        <div class="card-body text-center">
            <h4 class="card-title mb-3 text-success"><?= lang('Auth.useMagicLink') ?></h4>

            <p ><b><?= lang('Auth.checkYourEmail') ?></b></p>

            <p><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
