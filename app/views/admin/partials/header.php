<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css'); ?>">
</head>
<body>
<div class="container-fluid">
    <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert alert-danger m-3 mb-0"><?= e($_SESSION['admin_error']); ?></div>
        <?php unset($_SESSION['admin_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['admin_success'])): ?>
        <div class="alert alert-success m-3 mb-0"><?= e($_SESSION['admin_success']); ?></div>
        <?php unset($_SESSION['admin_success']); ?>
    <?php endif; ?>
    <div class="row min-vh-100">
