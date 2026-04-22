<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Employees Manager</h1>

    <?php if (!empty($_SESSION['admin_success'])): ?><div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div><?php unset($_SESSION['admin_success']); endif; ?>
    <?php if (!empty($_SESSION['admin_error'])): ?><div class="alert alert-danger"><?= e($_SESSION['admin_error']); ?></div><?php unset($_SESSION['admin_error']); endif; ?>

    <div class="card mb-4">
        <div class="card-header">Add employee profile</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="<?= $config['app']['base_url'] ?>admin/index.php?page=employees&action=create" class="row g-3">
                <div class="col-md-4"><label class="form-label">Name (Nepali)</label><input name="name_np" required class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Name (English)</label><input name="name_en" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Position (Nepali)</label><input name="designation_np" required class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Position (English)</label><input name="designation_en" class="form-control"></div>
                <div class="col-md-2"><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="0" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Photo</label><input type="file" name="photo" accept="image/png,image/jpeg" class="form-control"></div>
                <div class="col-12"><button class="btn btn-primary">Save Employee</button></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Existing employees</div>
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead><tr><th>Photo</th><th>Name</th><th>Position</th><th>Order</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php if (!empty($employee['photo_path'])): ?><img src="<?= e(mediaUrl($config, $employee['photo_path'])); ?>" alt="<?= e($employee['name_np']); ?>" style="width:56px;height:56px;object-fit:cover;border-radius:8px;"><?php endif; ?></td>
                        <td><?= e($employee['name_np']); ?></td>
                        <td><?= e($employee['designation_np']); ?></td>
                        <td><?= (int) $employee['sort_order']; ?></td>
                        <td class="text-end">
                            <form method="POST" action="<?= $config['app']['base_url'] ?>admin/index.php?page=employees&action=delete&id=<?= (int) $employee['id']; ?>" onsubmit="return confirm('Delete this employee?');">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
