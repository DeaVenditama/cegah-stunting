<?php
$session = session();
$errors = $session->getFlashdata('errors');
$success = $session->getFlashdata('success');
$warning = $session->getFlashdata('warning');
?>

<?php if ($errors != null) : ?>
    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
        <i class="mdi mdi-block-helper label-icon"></i><strong>Terjadi Kesalahan</strong> - <?= $errors ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if ($success != null) : ?>
    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
        <i class="mdi mdi-check-all label-icon"></i><strong>Sukses</strong> - <?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if ($warning != null) : ?>
    <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
        <i class="mdi mdi-alert-circle-outline label-icon"></i><strong>Peringatan</strong> - <?= $warning ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>