<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Gallery Manager (Event Folders)</h1>

    <?php if (!empty($_SESSION['admin_success'])): ?><div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div><?php unset($_SESSION['admin_success']); endif; ?>
    <?php if (!empty($_SESSION['admin_error'])): ?><div class="alert alert-danger"><?= e($_SESSION['admin_error']); ?></div><?php unset($_SESSION['admin_error']); endif; ?>

    <div class="card mb-4">
        <div class="card-header">Create event folder and upload media</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="<?= $config['app']['base_url'] ?>admin/index.php?page=gallery&action=create" class="row g-3">
                <div class="col-md-4"><label class="form-label">Event Title (Nepali)</label><input name="title_np" required class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Event Title (English)</label><input name="title_en" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Event Date</label><input type="date" name="event_date" class="form-control"></div>
                <div class="col-12"><label class="form-label">Photos/Videos</label><input type="file" name="media_files[]" multiple accept="image/png,image/jpeg,video/mp4,video/webm,video/quicktime" class="form-control"></div>
                <div class="col-12"><button class="btn btn-primary">Create Folder</button></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Existing event folders</div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead><tr><th>Folder/Event</th><th>Date</th><th>Total Media</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php foreach ($albums as $album): ?>
                    <tr>
                        <td><?= e($album['title_np']); ?></td>
                        <td><?= e((string) ($album['event_date'] ?: '-')); ?></td>
                        <td><?= (int) $album['total_items']; ?></td>
                        <td class="text-end d-flex justify-content-end gap-2">
                            <a class="btn btn-sm btn-outline-primary" href="<?= $config['app']['base_url'] ?>admin/index.php?page=gallery&action=view&id=<?= (int) $album['id']; ?>">Open Folder</a>
                            <form method="POST" action="<?= $config['app']['base_url'] ?>admin/index.php?page=gallery&action=delete&id=<?= (int) $album['id']; ?>" onsubmit="return confirm('Delete this folder and all media?');">
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
