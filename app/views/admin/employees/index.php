<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Employees Manager</h1>
    <form method="POST" enctype="multipart/form-data" action="<?= url('admin/index.php?page=employees&action=create'); ?>" class="row g-3 mb-4">
        <div class="col-md-4"><input name="name_np" required class="form-control" placeholder="Name NP"></div>
        <div class="col-md-4"><input name="designation_np" required class="form-control" placeholder="Designation NP"></div>
        <div class="col-md-4"><input type="file" name="photo" accept="image/png,image/jpeg" class="form-control"></div>
        <div class="col-12"><button class="btn btn-primary">Save Employee</button></div>
    </form>
    <table class="table table-striped">
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?php if (!empty($employee['photo_path'])): ?><img src="<?= asset('images/' . ltrim($employee['photo_path'], '/')); ?>" style="width:48px;height:48px;object-fit:cover;"><?php endif; ?></td>
                <td><?= e($employee['name_np']); ?></td><td><?= e($employee['designation_np']); ?></td>
                <td><form method="POST" action="<?= url('admin/index.php?page=employees&action=delete&id=' . (int) $employee['id']); ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
