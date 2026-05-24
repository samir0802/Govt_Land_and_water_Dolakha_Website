<!doctype html><html><head><meta charset="utf-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-5"><form method="post" action="<?= url('admin/index.php?page=login'); ?>" class="card p-3 col-md-4 mx-auto">
<?= csrf_input(); ?>
<?php if (!empty($_SESSION['auth_error'])): ?>
<div class="alert alert-danger"><?= e($_SESSION['auth_error']); ?></div>
<?php unset($_SESSION['auth_error']); endif; ?>
<input name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<button class="btn btn-primary">Login</button></form></div></body></html>
