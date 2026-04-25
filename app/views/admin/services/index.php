<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4">
    <?php $isEdit = !empty($editService); ?>
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h5 mb-3"><?= $isEdit ? 'Edit Service' : 'Add Service'; ?></h1>
                    <form method="POST" action="<?= url('admin/index.php?page=services&action=' . ($isEdit ? 'update&id=' . (int) $editService['id'] : 'create')); ?>" class="row g-3">
                        <div class="col-12"><label class="form-label">Title (Nepali)</label><input name="title_np" class="form-control" value="<?= e($editService['title_np'] ?? ''); ?>" required></div>
                        <div class="col-12"><label class="form-label">Title (English)</label><input name="title_en" class="form-control" value="<?= e($editService['title_en'] ?? ''); ?>"></div>
                        <div class="col-12"><label class="form-label">Description (Nepali)</label><textarea name="description_np" class="form-control" rows="3" required><?= e($editService['description_np'] ?? ''); ?></textarea></div>
                        <div class="col-12"><label class="form-label">Description (English)</label><textarea name="description_en" class="form-control" rows="3"><?= e($editService['description_en'] ?? ''); ?></textarea></div>
                        <div class="col-12"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= (int) ($editService['sort_order'] ?? 0); ?>"></div>
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-success" type="submit">Save Service</button>
                            <?php if ($isEdit): ?><a class="btn btn-outline-secondary" href="<?= url('admin/index.php?page=services'); ?>">Cancel</a><?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Services List</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle">
                            <thead><tr><th>Nepali Title</th><th>Order</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?= e($service['title_np']); ?></td>
                                    <td><?= (int) $service['sort_order']; ?></td>
                                    <td class="d-flex gap-2">
                                        <a class="btn btn-sm btn-warning" href="<?= url('admin/index.php?page=services&action=edit&id=' . (int) $service['id']); ?>">Edit</a>
                                        <form method="POST" action="<?= url('admin/index.php?page=services&action=delete&id=' . (int) $service['id']); ?>" onsubmit="return confirm('Delete this service?')">
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
